<template>
    <div class="flex justify-between items-center">
        <div class="flex-1 mr-6">
            <span v-show="empty && !uploading" class="">{{ prompt_text }}</span>

            <div class="flex items-end" v-show="!empty && !uploading">
                <a
                    :href="downloadPath"
                    :download="filename"
                    class="flex items-center hover:text-blue-600"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="stroke-current h-5 mr-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                    <span>{{ filename }}</span>
                </a>
                <button
                    @click="clearImage"
                    v-if="deletePath"
                    class="text-xs hover:text-red-500 mx-4"
                >
                    Remove file
                </button>
            </div>
            <div v-show="uploading" class="flex items-center">
                <div class="h-2 w-full rounded bg-gray-400">
                    <div
                        class="h-2 w-full bg-red-500 rounded"
                        :style="`transform-origin: left; transform: scale(${
                            progress / 100
                        },1)`"
                    ></div>
                </div>
            </div>
            <div></div>
        </div>
        <button
            @click="chooseFile"
            class="shadow font-semibold p-1 rounded hover:bg-gray-200 text-sm"
        >
            Upload File
        </button>
        <input type="file" ref="fileInput" class="hidden" @input="handleFile" />
    </div>
</template>

<script type="text/babel">
import { uploadFile } from "../lib/files";
import { del } from "../apis/http";

export default {
    props: [
        "upload-path",
        "delete-path",
        "download-path",
        "filename",
        "prompt",
        "name",
    ],

    props: {
        "upload-path": String,
        "delete-path": String,
        "download-path": String,
        filename: String,
        prompt: String,
        name: String,
        "max-size": {
            type: Number,
            default: 10,
        },
    },

    data() {
        return {
            uploading: false,
            progress: 0,
        };
    },

    computed: {
        empty() {
            return !this.downloadPath;
        },

        prompt_text() {
            return this.prompt || "Choose a file to upload";
        },

        maxFileSize() {
            return this.maxSize * 1000 * 1024;
        },
    },

    methods: {
        chooseFile() {
            this.$refs.fileInput.click();
        },

        handleFile({ target }) {
            if (target.files.length) {
                this.processFile(target.files[0]);
            }
        },

        processFile(file) {
            this.validateFile(file)
                .then(this.upload)
                .catch((err) => this.$emit("invalid-file", err));
        },

        validateFile(file) {
            return new Promise((resolve, reject) => {
                const tooBig = (size) => size > this.maxFileSize;

                if (tooBig(file.size)) {
                    return reject(
                        `File size is greater than ${this.maxSize}MB`
                    );
                }

                resolve(file);
            });
        },

        upload(file) {
            const setProgress = (progress) => (this.progress = progress);
            this.uploading = true;

            uploadFile(file)
                .to(this.uploadPath, this.name, setProgress)
                .then(({ data }) => this.onSuccess(data))
                .catch(this.onError)
                .then(() => (this.uploading = false));
        },

        clearImage() {
            del(this.deletePath)
                .then(() => {
                    this.$emit("cleared");
                })
                .catch(() => this.$emit("clear-failed"));
        },

        onSuccess(response) {
            this.$emit("uploaded");
        },

        onError({ status, data }) {
            if (status === 422) {
                return this.$emit("invalid-file", data.errors[this.name][0]);
            }
            this.$emit("upload-failed", "Server error uploading image");
        },
    },
};
</script>
