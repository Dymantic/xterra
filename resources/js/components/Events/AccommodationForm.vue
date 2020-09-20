<template>
    <form @submit.prevent="submit">
        <div class="my-6">
            <p class="font-bold">Name</p>
            <p class="my-2 text-gray-600">
                The name of the accommodation
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
                A brief description of the accommodation.
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

        <div class="my-6">
            <p class="font-bold">Phone number</p>
            <p class="my-2 text-gray-600">
                A valid phone number people can call
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    label=""
                    :error-msg="formErrors.phone"
                    v-model="formData.phone"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Email</p>
            <p class="my-2 text-gray-600">
                A valid email address to get hold of the accommodation
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    type="email"
                    :error-msg="formErrors.email"
                    v-model="formData.email"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Link</p>
            <p class="my-2 text-gray-600">
                The complete link for booking. Remember to include the https://
                or http:// part.
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    type="text"
                    :error-msg="formErrors.link"
                    v-model="formData.link"
                ></input-field>
            </div>
        </div>

        <div class="my-10">
            <submit-button :waiting="waiting">Save Accommodation</submit-button>
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

    props: ["accommodation"],

    data() {
        return {
            waiting: false,
            formData: {
                name: { en: "", zh: "" },
                description: { en: "", zh: "" },
                phone: "",
                email: "",
                link: "",
            },
            formErrors: {
                name: "",
                description: "",
                phone: "",
                email: "",
                link: "",
            },
        };
    },

    mounted() {
        if (this.accommodation) {
            this.formData = {
                name: {
                    en: this.accommodation.name.en,
                    zh: this.accommodation.name.zh,
                },
                description: {
                    en: this.accommodation.description.en,
                    zh: this.accommodation.description.zh,
                },
                email: this.accommodation.email,
                phone: this.accommodation.phone,
                link: this.accommodation.link,
            };
        }
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            const action = this.accommodation
                ? "events/updateAccommodation"
                : "events/createAccommodation";
            const payload = !this.accommodation
                ? {
                      event_id: this.$route.params.id,
                      formData: this.formData,
                  }
                : {
                      accommodation_id: this.accommodation.id,
                      formData: this.formData,
                  };

            this.$store
                .dispatch(action, payload)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            if (!this.accommodation) {
                this.formData = {
                    name: { en: "", zh: "" },
                    description: { en: "", zh: "" },
                    phone: "",
                    email: "",
                    link: "",
                };
            }

            notify.success({ message: "Accommodation saved" });
            this.$router.push(
                `/events/${this.$route.params.id}/edit/accommodation`
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
            notify.error({ message: "Failed to save accommodation." });
        },
    },
};
</script>
