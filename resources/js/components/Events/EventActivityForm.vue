<template>
    <div>
        <p class="mb-8 text-lg font-bold">
            Add a new race or activity for this event.
        </p>
        <form @submit.prevent="submit">
            <div class="my-6">
                <p class="font-bold">Name</p>
                <p class="my-2 text-gray-600">The name for this activity</p>
                <div class="pl-6">
                    <input-field
                        class="mb-4"
                        label="English"
                        :error-msg="formErrors['name.en']"
                        v-model="formData.name.en"
                    ></input-field>
                    <input-field
                        class="my-4"
                        label="Chinese"
                        :error-msg="formErrors['name.zh']"
                        v-model="formData.name.zh"
                    ></input-field>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold">Race or Activity</p>
                <p class="my-2 text-gray-600">
                    Does this count as a race or an activity?
                </p>
                <div class="pl-6">
                    <radio-input
                        class="mb-4"
                        label="Race"
                        :error-msg="``"
                        thing="race"
                        v-model="formData.race_activity"
                    ></radio-input>
                    <radio-input
                        class="my-4"
                        label="Activity"
                        :error-msg="``"
                        thing="activity"
                        v-model="formData.race_activity"
                    ></radio-input>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold">Category</p>
                <p class="my-2 text-gray-600">
                    Which category does the activity belong to?
                </p>
                <div class="pl-6">
                    <select-field
                        class="mb-4"
                        label="English"
                        :error-msg="formErrors.category"
                        v-model="formData.category"
                        :options="categories"
                    ></select-field>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold">Distance</p>
                <p class="my-2 text-gray-600">
                    The distance. Just leave blank if not appropriate for this
                    category.
                </p>
                <div class="pl-6">
                    <input-field
                        class="mb-4"
                        label="English"
                        :error-msg="formErrors['distance.en']"
                        v-model="formData.distance.en"
                    ></input-field>
                    <input-field
                        class="my-4"
                        label="Chinese"
                        :error-msg="formErrors['distance.zh']"
                        v-model="formData.distance.zh"
                    ></input-field>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold">Description</p>
                <p class="my-2 text-gray-600">
                    A short description of this activity or race.
                </p>
                <div class="pl-6">
                    <textarea-field
                        class="mb-4"
                        label="English"
                        :error-msg="formErrors['description.en']"
                        v-model="formData.description.en"
                    ></textarea-field>
                    <textarea-field
                        class="my-4"
                        label="Chinese"
                        :error-msg="formErrors['description.zh']"
                        v-model="formData.description.zh"
                    ></textarea-field>
                </div>
            </div>

            <div class="my-8 flex justify-end">
                <submit-button :waiting="waiting">Submit</submit-button>
            </div>
        </form>
    </div>
</template>

<script type="text/babel">
import InputField from "../Forms/InputField";
import RadioInput from "../Forms/RadioInput";
import TextareaField from "../Forms/TextareaField";
import SelectField from "../Forms/SelectField";
import SubmitButton from "../Forms/SubmitButton";
import { clearValidationErrors, setValidationErrors } from "../../lib/forms";
import { notify } from "../Messaging/notify";

export default {
    components: {
        InputField,
        RadioInput,
        TextareaField,
        SelectField,
        SubmitButton,
    },

    props: ["activity"],

    data() {
        return {
            waiting: false,
            formData: {
                name: { en: "", zh: "" },
                distance: { en: "", zh: "" },
                description: { en: "", zh: "" },
                category: "",
                race_activity: "",
            },
            formErrors: {
                "name.en": "",
                "name.zh": "",
                "distance.en": "",
                "distance.zh": "",
                "description.zh": "",
                category: "",
            },
        };
    },

    computed: {
        categories() {
            return this.$store.state.events.activity_categories;
        },
    },

    mounted() {
        if (this.activity) {
            this.setForm();
        }
    },

    methods: {
        setForm() {
            this.formData = {
                name: { en: this.activity.name.en, zh: this.activity.name.zh },
                distance: {
                    en: this.activity.distance.en,
                    zh: this.activity.distance.zh,
                },
                description: {
                    en: this.activity.description.en,
                    zh: this.activity.description.zh,
                },
                category: this.activity.category,
                race_activity: this.activity.is_race ? "race" : "activity",
            };
        },

        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            if (this.activity) {
                return this.updateActivity();
            }

            if (this.formData.race_activity === "race") {
                return this.submitRace();
            }

            if (this.formData.race_activity === "activity") {
                return this.submitActivity();
            }
        },

        submitRace() {
            this.$store
                .dispatch("events/addEventRace", {
                    event_id: this.$route.params.id,
                    formData: this.formData,
                })
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        updateActivity() {
            const action =
                this.formData.race_activity === "activity"
                    ? "events/updateActivity"
                    : "events/updateRace";
            this.$store
                .dispatch(action, {
                    activity_id: this.activity.id,
                    formData: this.formData,
                })
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        submitActivity() {
            this.$store
                .dispatch("events/addEventActivity", {
                    event_id: this.$route.params.id,
                    formData: this.formData,
                })
                .catch(this.onError)
                .then(this.onSuccess)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            const message = this.activity
                ? "Activity updated"
                : "New activity saved";
            notify.success({ message });
            this.$router.push(
                `/events/${this.$route.params.id}/edit/activities`
            );
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }

            notify.error({ message: "Failed to save activity information." });
        },
    },
};
</script>
