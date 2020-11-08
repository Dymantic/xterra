<template>
    <form @submit.prevent="submit" class="max-w-lg">
        <div class="my-6">
            <p class="font-bold">Page Title</p>
            <p class="my-2 text-gray-600">The title for this page.</p>
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
            <p class="font-bold">Menu Name</p>
            <p class="my-2 text-gray-600">
                The name to use in the drop-down menu for the main navbar.
                Should be short enough to fit in nicely.
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    label="English"
                    :error-msg="formErrors.menu_name"
                    v-model="formData.menu_name.en"
                ></input-field>
                <input-field
                    class="my-4"
                    label="Chinese"
                    v-model="formData.menu_name.zh"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Description</p>
            <p class="my-2 text-gray-600">
                Describe the content of the page. This is very important for
                SEO. Do not make it too long, Just two or three normal
                sentences.
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
            <p class="font-bold">Intro</p>
            <p class="my-2 text-gray-600">
                A brief introduction to the page.
            </p>
            <div class="pl-6">
                <textarea-field
                    class="mb-4"
                    label="English"
                    :error-msg="formErrors.blurb"
                    v-model="formData.blurb.en"
                ></textarea-field>
                <textarea-field
                    class="my-4"
                    label="Chinese"
                    v-model="formData.blurb.zh"
                ></textarea-field>
            </div>
        </div>

        <div class="my-6">
            <submit-button :waiting="waiting">Save Page Info</submit-button>
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
    components: { InputField, TextareaField, SubmitButton },

    props: ["page"],

    data() {
        return {
            waiting: false,
            formData: {
                title: { en: "", zh: "" },
                description: { en: "", zh: "" },
                blurb: { en: "", zh: "" },
                menu_name: { en: "", zh: "" },
            },
            formErrors: {
                title: "",
                description: "",
                blurb: "",
                menu_name: "",
            },
        };
    },

    mounted() {
        if (this.page) {
            this.formData = {
                title: { en: this.page.title.en, zh: this.page.title.zh },
                description: {
                    en: this.page.description.en,
                    zh: this.page.description.zh,
                },
                blurb: { en: this.page.blurb.en, zh: this.page.blurb.zh },
                menu_name: {
                    en: this.page.menu_name.en,
                    zh: this.page.menu_name.zh,
                },
            };
        }
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            const action = this.page ? "pages/update" : "pages/create";
            const payload = this.page
                ? { formData: this.formData, page_id: this.page.id }
                : this.formData;

            this.$store
                .dispatch(action, payload)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            notify.success({ message: "Page meta data saved" });
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }
            notify.error({ message: "Failed to save page info" });
        },
    },
};
</script>
