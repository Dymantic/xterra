<template>
    <div>
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
                <p class="font-bold">Intro</p>
                <p class="my-2 text-gray-600">
                    A brief introduction or description of the race or activity.
                    This appears on the main event page.
                </p>
                <div class="pl-6">
                    <textarea-field
                        class="mb-4"
                        label="English"
                        :error-msg="formErrors.intro"
                        v-model="formData.intro.en"
                    ></textarea-field>
                    <textarea-field
                        class="my-4"
                        label="Chinese"
                        v-model="formData.intro.zh"
                    ></textarea-field>
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
                <p class="font-bold">Race Date</p>
                <p class="my-2 text-gray-600">
                    When will the race/activity occur?
                </p>
                <div class="pl-6">
                    <date-field
                        class="my-6 mr-6"
                        :inline="true"
                        label=""
                        help-text=""
                        :error-msg="formErrors.date"
                        v-model="formData.date"
                    ></date-field>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold">Venue</p>
                <p class="my-2 text-gray-600">
                    The name of race venue
                </p>
                <div class="pl-6">
                    <input-field
                        class="mb-4"
                        label="English"
                        :error-msg="formErrors['venue_name']"
                        v-model="formData.venue_name.en"
                    ></input-field>
                    <input-field
                        class="my-4"
                        label="Chinese"
                        v-model="formData.venue_name.zh"
                    ></input-field>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold">Venue Address</p>
                <p class="my-2 text-gray-600">
                    The actual address for the race
                </p>
                <div class="pl-6">
                    <input-field
                        class="mb-4"
                        label="English"
                        :error-msg="formErrors['venue_address']"
                        v-model="formData.venue_address.en"
                    ></input-field>
                    <input-field
                        class="my-4"
                        label="Chinese"
                        v-model="formData.venue_address.zh"
                    ></input-field>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold">Map Link</p>
                <p class="my-2 text-gray-600">
                    A valid link for an online map, such as Google Maps
                </p>
                <div class="pl-6">
                    <input-field
                        class="my-6"
                        label=""
                        help-text="You must include the http:// or https:// part"
                        :error-msg="formErrors.map_link"
                        v-model="formData.map_link"
                    ></input-field>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold">Registration Link</p>
                <p class="my-2 text-gray-600">
                    A valid link for registration for the race
                </p>
                <div class="pl-6">
                    <input-field
                        class="my-6"
                        label=""
                        help-text="You must include the http:// or https:// part"
                        :error-msg="formErrors.registration_link"
                        v-model="formData.registration_link"
                    ></input-field>
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
import DateField from "../Forms/DateField";
import { clearValidationErrors, setValidationErrors } from "../../lib/forms";
import { notify } from "../Messaging/notify";
import {toStandardDateString} from "../../lib/dates";

export default {
    components: {
        InputField,
        RadioInput,
        TextareaField,
        SelectField,
        DateField,
        SubmitButton,
    },

    props: ["activity"],

    data() {
        return {
            waiting: false,
            formData: {
                name: { en: "", zh: "" },
                distance: { en: "", zh: "" },
                intro: { en: "", zh: "" },
                venue_name: { en: "", zh: "" },
                venue_address: { en: "", zh: "" },
                map_link: "",
                registration_link: "",
                date: toStandardDateString(new Date()),
                category: "",
                race_activity: "",
            },
            formErrors: {
                "name.en": "",
                "name.zh": "",
                "distance.en": "",
                intro: "",
                "distance.zh": "",
                venue_name: "",
                venue_address: "",
                date: "",
                map_link: "",
                registration_link: "",
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

                intro: {
                    en: this.activity.intro.en,
                    zh: this.activity.intro.zh,
                },

                venue_name: {
                    en: this.activity.venue_name.en,
                    zh: this.activity.venue_name.zh,
                },
                venue_address: {
                    en: this.activity.venue_address.en,
                    zh: this.activity.venue_address.zh,
                },
                date: toStandardDateString(this.activity.date
                    ? new Date(this.activity.date)
                    : new Date()),
                map_link: this.activity.map_link,
                registration_link: this.activity.registration_link,
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
            const redirect = `/events/${
                this.$route.params.id || this.$route.params.event
            }/edit/activities`;
            this.$router.push(redirect);
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
