<template>
    <form @submit.prevent="submit">
        <div class="my-6">
            <p class="font-bold">Heading</p>
            <p class="my-2 text-gray-600">
                The main heading for the homepage banner
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    label="English"
                    :error-msg="formErrors.heading"
                    v-model="formData.heading.en"
                ></input-field>
                <input-field
                    class="my-4"
                    label="Chinese"
                    v-model="formData.heading.zh"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Sub-Heading</p>
            <p class="my-2 text-gray-600">
                The secondary heading for the homepage banner
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    label="English"
                    :error-msg="formErrors.subheading"
                    v-model="formData.subheading.en"
                ></input-field>
                <input-field
                    class="my-4"
                    label="Chinese"
                    v-model="formData.subheading.zh"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <submit-button :waiting="waiting">Save banner text</submit-button>
        </div>
    </form>
</template>

<script type="text/babel">
import InputField from "../Forms/InputField";
import SubmitButton from "../Forms/SubmitButton";
import { clearValidationErrors, setValidationErrors } from "../../lib/forms";
import { notify } from "../Messaging/notify";

export default {
    components: {
        InputField,
        SubmitButton,
    },

    props: ["banner-text"],

    data() {
        return {
            waiting: false,
            formData: {
                heading: { en: "", zh: "" },
                subheading: { en: "", zh: "" },
            },
            formErrors: {
                heading: "",
                subheading: "",
            },
        };
    },

    mounted() {
        if (this.bannerText) {
            this.formData = {
                heading: {
                    en: this.bannerText.heading.en,
                    zh: this.bannerText.heading.zh,
                },
                subheading: {
                    en: this.bannerText.subheading.en,
                    zh: this.bannerText.subheading.zh,
                },
            };
        }
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            this.$store
                .dispatch("homepage/updateBannerText", this.formData)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            notify.success({ message: "Text saved" });
            this.$router.push("/homepage/banner-text");
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }
            notify.error({ message: "Unable to save banner text" });
        },
    },
};
</script>
