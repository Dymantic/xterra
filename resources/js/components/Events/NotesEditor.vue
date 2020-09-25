<template>
    <div>
        <div class="my-8">
            <language-selector v-model="lang"></language-selector>
        </div>

        <div v-show="lang === 'en'">
            <wysiwyg v-model="formData.notes.en"></wysiwyg>
        </div>

        <div v-show="lang === 'zh'">
            <wysiwyg v-model="formData.notes.zh"></wysiwyg>
        </div>

        <div class="my-12">
            <submit-button :waiting="waiting" role="button" @click.native="save"
                >Save Notes</submit-button
            >
        </div>
    </div>
</template>

<script type="text/babel">
import Wysiwyg from "@dymantic/vue-trix-editor";
import TextareaField from "../Forms/TextareaField";
import SubmitButton from "../Forms/SubmitButton";
import LanguageSelector from "../LanguageSelector";

export default {
    components: {
        Wysiwyg,
        TextareaField,
        SubmitButton,
        LanguageSelector,
    },

    props: ["initial", "waiting"],

    data() {
        return {
            lang: "en",
            formData: {
                notes: { en: this.initial.en, zh: this.initial.zh },
            },
            formErrors: {
                notes: "",
            },
        };
    },

    methods: {
        save() {
            this.$emit("save", this.formData.notes);
        },
    },
};
</script>
