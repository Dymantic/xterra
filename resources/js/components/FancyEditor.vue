<template>
    <page>
        <page-header :title="editorTitle">
            <router-link class="btn mr-4" :to="backTo">Back</router-link>
            <submit-button
                role="button"
                @click.native="save"
                :waiting="saving"
                class="btn btn-dark"
                >Save</submit-button
            >
        </page-header>

        <div class="border border-gray-200 p-6 rounded-lg" id="editor"></div>
    </page>
</template>

<script>
import Page from "./Page";
import PageHeader from "./PageHeader";
import SubmitButton from "./Forms/SubmitButton";
import EditorJS from "@editorjs/editorjs";
import ImageTool from "@editorjs/image";
import Table from "@editorjs/table";
import IllustratedText from "../editorjs/IllustratedText";

export default {
    components: {
        Page,
        PageHeader,
        SubmitButton,
    },

    props: [
        "initial-data",
        "upload-images-to",
        "saving",
        "editor-title",
        "back-to",
    ],

    data() {
        return {
            editor: null,
        };
    },

    computed: {
        token() {
            return document.querySelector("#csrf-token-meta").content;
        },
    },

    mounted() {
        this.editor = new EditorJS({
            holder: "editor",
            tools: {
                illustratedText: {
                    class: IllustratedText,
                    inlineToolbar: true,
                    config: {
                        image_upload_path: this.uploadImagesTo,
                    },
                },
                image: {
                    class: ImageTool,
                    config: {
                        additionalRequestHeaders: {
                            "X-CSRF-TOKEN": this.token,
                        },
                        endpoints: {
                            byFile: this.uploadImagesTo,
                            byUrl: this.uploadImagesTo,
                        },
                    },
                },
                table: {
                    class: Table,
                },
            },
            data: this.initialData,
        });
    },

    methods: {
        save() {
            this.editor.save().then((content) => this.$emit("save", content));
        },
    },
};
</script>
