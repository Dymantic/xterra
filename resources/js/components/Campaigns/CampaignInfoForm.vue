<template>
    <form @submit.prevent="submit" class="max-w-lg">
        <div class="my-6">
            <p class="font-bold">Title</p>
            <p class="my-2 text-gray-600">The title for the campaign</p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    label="English"
                    :error-msg="formErrors.title"
                    v-model="formData.title.en"
                ></input-field>
                <input-field
                    class="my-4"
                    label="Chinese"
                    v-model="formData.title.zh"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Description</p>
            <p class="my-2 text-gray-600">
                A brief description of the campaign, mostly for SEO purposes.
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
            <p class="font-bold">Introduction</p>
            <p class="my-2 text-gray-600">
                A short introduction to the campaign. This will be shown on the
                home page of the website.
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
            <submit-button :waiting="waiting">Save Campaign Info</submit-button>
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

    props: ["campaign"],

    data() {
        return {
            waiting: false,
            formData: {
                title: { en: "", zh: "" },
                intro: { en: "", zh: "" },
                description: { en: "", zh: "" },
            },
            formErrors: {
                title: "",
                intro: "",
                description: "",
            },
        };
    },

    mounted() {
        if (this.campaign) {
            this.formData = {
                title: this.campaign.title,
                intro: this.campaign.intro,
                description: this.campaign.description,
            };
        }
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            const action = this.campaign
                ? "campaigns/update"
                : "campaigns/create";
            const payload = this.campaign
                ? {
                      campaign_id: this.campaign.id,
                      formData: this.formData,
                  }
                : this.formData;

            this.$store
                .dispatch(action, payload)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            const redirect = this.campaign
                ? `/campaigns/${this.campaign.id}/show`
                : "/campaigns";
            notify.success({ message: "Campaign info has been saved." });
            this.$router.push(redirect);
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }
            notify.error({ message: "Unable to save campaign info" });
        },
    },
};
</script>
