<template>
    <form @submit.prevent="submit" class="max-w-lg">
        <div class="my-6">
            <p class="font-bold">Title</p>
            <p class="my-2 text-gray-600">The title for this gallery</p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    label="English"
                    :error-msg="formErrors['title']"
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
                A brief description of the gallery.
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
            <submit-button :waiting="waiting">Save Gallery</submit-button>
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

    props: ["gallery"],

    data() {
        return {
            waiting: false,
            formData: {
                title: { en: "", zh: "" },
                description: { en: "", zh: "" },
            },
            formErrors: {
                title: "",
                description: "",
            },
        };
    },

    mounted() {
        if (this.gallery) {
            this.formData = {
                title: {
                    en: this.gallery.title.en,
                    zh: this.gallery.title.zh,
                },
                description: {
                    en: this.gallery.description.en,
                    zh: this.gallery.description.zh,
                },
            };
        }
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            const action = this.gallery
                ? "galleries/update"
                : "galleries/create";
            const payload = this.gallery
                ? {
                      gallery_id: this.gallery.id,
                      formData: this.formData,
                  }
                : this.formData;

            this.$store
                .dispatch(action, payload)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess(gallery) {
            const gall_id = this.gallery ? this.gallery.id : gallery.id;
            notify.success({ message: "Gallery saved" });
            this.$router.push(`/galleries/${gall_id}/show`);
        },

        onError({ status, data }) {
            if (status === 422) {
                this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                );
                return notify.warn({ message: "Some input was not valid" });
            }
            notify.error({ message: "Failed to save gallery" });
        },
    },
};
</script>
