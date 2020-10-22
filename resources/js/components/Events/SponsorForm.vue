<template>
    <form @submit.prevent="submit" class="max-w-lg">
        <div class="my-6">
            <p class="font-bold">Name</p>
            <p class="my-2 text-gray-600">
                The name of the sponsor
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
                A brief description of the sponsor.
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
            <p class="font-bold">Link</p>
            <p class="my-2 text-gray-600">
                The complete link for the sponsor. Remember to include the
                https:// or http:// part.
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
            <submit-button :waiting="waiting">Save Sponsor</submit-button>
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

    props: ["sponsor"],

    data() {
        return {
            waiting: false,
            formData: {
                name: { en: "", zh: "" },
                description: { en: "", zh: "" },
                link: "",
            },
            formErrors: {
                name: "",
                description: "",
                link: "",
            },
        };
    },

    mounted() {
        if (this.sponsor) {
            this.formData = {
                name: { en: this.sponsor.name.en, zh: this.sponsor.name.zh },
                description: {
                    en: this.sponsor.description.en,
                    zh: this.sponsor.description.zh,
                },
                link: this.sponsor.link,
            };
        }
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            const action = this.sponsor
                ? "events/updateSponsor"
                : "events/createSponsor";
            const payload = this.sponsor
                ? {
                      sponsor_id: this.sponsor.id,
                      formData: this.formData,
                  }
                : {
                      event_id: this.$route.params.id,
                      formData: this.formData,
                  };

            this.$store
                .dispatch(action, payload)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            notify.success({ message: "Sponsor info saved" });
            this.$router.push(`/events/${this.$route.params.id}/edit/sponsors`);
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }
            notify.error({ message: "Failed to save sponsor info" });
        },
    },
};
</script>
