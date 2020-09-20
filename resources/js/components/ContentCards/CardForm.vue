<template>
    <form @submit.prevent="submit" class="max-w-lg">
        <div class="my-6">
            <p class="font-bold">Card Category</p>
            <p class="my-2 text-gray-600">
                The category of content. E.g, 'blog', 'event', 'shop', etc.
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    label="English"
                    :error-msg="formErrors.category"
                    v-model="formData.category.en"
                ></input-field>
                <input-field
                    class="my-4"
                    label="Chinese"
                    v-model="formData.category.zh"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Title</p>
            <p class="my-2 text-gray-600">The main text heading for the card</p>
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
            <p class="font-bold">Link</p>
            <p class="my-2 text-gray-600">
                Where the card should link to. Don't forget the http(s)://
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
            <submit-button :waiting="waiting">Save Card</submit-button>
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

    props: ["card"],

    data() {
        return {
            waiting: false,
            formData: {
                category: { en: "", zh: "" },
                title: { en: "", zh: "" },
                link: "",
            },
            formErrors: {
                category: "",
                title: "",
                link: "",
            },
        };
    },

    mounted() {
        if (this.card) {
            this.formData = {
                title: { en: this.card.title.en, zh: this.card.title.zh },
                category: {
                    en: this.card.category.en,
                    zh: this.card.category.zh,
                },
                link: this.card.link,
            };
        }
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            const action = this.card ? "cards/update" : "cards/create";
            const payload = this.card
                ? {
                      card_id: this.card.id,
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
            notify.success({ message: "Card saved" });
            this.$router.push("/content-cards");
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }
            notify.error({ message: "Failed to save card." });
        },
    },
};
</script>
