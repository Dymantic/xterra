<template>
    <form @submit.prevent="submit">
        <div class="my-6">
            <p class="font-bold">Name</p>
            <p class="my-2 text-gray-600">
                The name of the travel route
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    label="English"
                    :error-msg="formErrors.name"
                    v-model="formData.name.en"
                ></input-field>
                <input-field
                    class="my-4"
                    label="Chinese"
                    v-model="formData.name.zh"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Description</p>
            <p class="my-2 text-gray-600">
                Concise instructions for travelers taking this route.
            </p>
            <div class="pl-6">
                <textarea-field
                    class="mb-4"
                    label="English"
                    :error-msg="formErrors.description"
                    v-model="formData.description.en"
                ></textarea-field>
                <textarea-field
                    class="my-4"
                    label="Chinese"
                    v-model="formData.description.zh"
                ></textarea-field>
            </div>
        </div>
        <div class="my-10">
            <submit-button :waiting="waiting">Save Travel Route</submit-button>
        </div>
    </form>
</template>

<script type="text/babel">
import InputField from "../Forms/InputField";
import TextareaField from "../Forms/TextareaField";
import SubmitButton from "../Forms/SubmitButton";
import { clearValidationErrors, setValidationErrors } from "../../lib/forms";
import { notify } from "../Messaging/notify";

export default {
    components: {
        InputField,
        TextareaField,
        SubmitButton,
    },

    props: ["travel-route"],

    data() {
        return {
            waiting: false,
            formData: {
                name: { en: "", zh: "" },
                description: { en: "", zh: "" },
            },
            formErrors: {
                name: "",
                description: "",
            },
        };
    },

    mounted() {
        if (this.travelRoute) {
            this.formData = {
                name: {
                    en: this.travelRoute.name.en,
                    zh: this.travelRoute.name.zh,
                },
                description: {
                    en: this.travelRoute.description.en,
                    zh: this.travelRoute.description.zh,
                },
            };
        }
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            const action = this.travelRoute
                ? "events/updateTravelRoute"
                : "events/createTravelRoute";
            const payload = !this.travelRoute
                ? {
                      event_id: this.$route.params.id,
                      formData: this.formData,
                  }
                : {
                      route_id: this.travelRoute.id,
                      formData: this.formData,
                  };

            this.$store
                .dispatch(action, payload)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            if (!this.travelRoute) {
                this.formData = {
                    name: { en: "", zh: "" },
                    description: { en: "", zh: "" },
                };
            }

            notify.success({ message: "Travel route saved" });
            this.$router.push(
                `/events/${this.$route.params.id}/edit/travel-routes`
            );
        },

        onError({ status, data }) {
            if (status === 422) {
                this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                );
                return notify.warn({ message: "Some input was not valid" });
            }
            notify.error({ message: "Failed to save travel route." });
        },
    },
};
</script>
