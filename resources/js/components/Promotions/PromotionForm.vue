<template>
    <form @submit.prevent="submit" class="max-w-lg">
        <div class="my-6">
            <p class="font-bold">Title</p>
            <p class="my-2 text-gray-600">The name of the store item</p>
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
            <p class="font-bold">Writeup</p>
            <p class="my-2 text-gray-600">
                A brief description of the item.
            </p>
            <div class="pl-6">
                <textarea-field
                    class="mb-4"
                    label="English"
                    :error-msg="formErrors.writeup"
                    v-model="formData.writeup.en"
                ></textarea-field>
                <textarea-field
                    class="my-4"
                    label="Chinese"
                    v-model="formData.writeup.zh"
                ></textarea-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Button Text</p>
            <p class="my-2 text-gray-600">
                What should the button show on the site?
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    label="English"
                    :error-msg="formErrors['button_text']"
                    v-model="formData.button_text.en"
                ></input-field>
                <input-field
                    class="my-4"
                    label="Chinese"
                    v-model="formData.button_text.zh"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Promoted Link</p>
            <p class="my-2 text-gray-600">
                The link to send the visitor to. Don't forget to include the
                https:// or http:// part
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    label=""
                    :error-msg="formErrors.link"
                    v-model="formData.link"
                ></input-field>
            </div>
        </div>
        <div class="my-6">
            <submit-button :waiting="waiting">Save Promotion</submit-button>
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

    props: ["promotion"],

    data() {
        return {
            waiting: false,
            formData: {
                title: { en: "", zh: "" },
                writeup: { en: "", zh: "" },
                button_text: { en: "", zh: "" },
                link: "",
            },
            formErrors: {
                title: "",
                writeup: "",
                button_text: "",
                link: "",
            },
        };
    },

    mounted() {
        if (this.promotion) {
            this.formData = {
                title: {
                    en: this.promotion.title.en,
                    zh: this.promotion.title.zh,
                },
                writeup: {
                    en: this.promotion.writeup.en,
                    zh: this.promotion.writeup.zh,
                },
                button_text: {
                    en: this.promotion.button_text.en,
                    zh: this.promotion.button_text.zh,
                },
                link: this.promotion.link,
            };
        }
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            const action = this.promotion
                ? "promotions/update"
                : "promotions/create";
            const payload = this.promotion
                ? {
                      promo_id: this.promotion.id,
                      formData: this.formData,
                  }
                : this.formData;

            this.$store
                .dispatch(action, payload)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess(promo) {
            const promo_id = this.promotion ? this.promotion.id : promo.id;
            notify.success({ message: "Promotion saved" });
            this.$router.push(`/promotions/${promo_id}/show`);
        },

        onError({ status, data }) {
            if (status === 422) {
                this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                );
                return notify.warn({ message: "Some input is invalid" });
            }
            notify.error({ message: "Failed to save promotion" });
        },
    },
};
</script>
