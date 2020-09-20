<template>
    <div>
        <div
            class="flex justify-between items-center mb-12 border-b border-gray-300 pb-3"
        >
            <p class="font-bold text-lg">{{ title }}</p>
            <button @click="chooseFiles" class="btn btn-dark">Add Files</button>
            <input
                type="file"
                ref="fileChooser"
                class="hidden"
                @input="handleFiles"
                multiple
            />
        </div>
        <div
            @drop.prevent="handleFiles"
            @dragenter.prevent="hovering = true"
            @dragover.prevent="hovering = true"
            @dragleave.prevent="hovering = false"
            class="min-h-screen"
            :class="{
                'bg-blue-100 border-2 border-dashed border-blue-500': hovering,
            }"
        >
            <div class="flex flex-wrap items-start" ref="sortable">
                <div
                    v-for="image in images"
                    :key="image.id"
                    :data-id="image.id"
                    class="m-4 shadow"
                >
                    <div class="w-40 h-40 relative">
                        <img
                            :src="image.src"
                            class="w-full h-full object-contain"
                            alt=""
                        />
                    </div>
                    <div class="text-right p-1">
                        <button
                            class="text-xs hover:text-red-500"
                            @click="removeImage(image)"
                            v-show="!deleting.includes(image.id)"
                        >
                            Delete
                        </button>
                        <span
                            class="text-xs"
                            v-show="deleting.includes(image.id)"
                            >deleting...</span
                        >
                    </div>
                </div>
            </div>
        </div>
        <div
            class="fixed bottom-0 right-0 p-6 m-4 z-50 bg-white shadow-lg"
            v-show="uploading_files.length"
        >
            <p class="font-bold mb-4">Uploads</p>
            <div
                v-for="upload in uploading_files"
                class="w-64 border-b border-gray-200"
            >
                <p class="w-64 truncate text-sm">{{ upload.name }}</p>
                <div class="h-2 w-full rounded bg-gray-400">
                    <div
                        class="h-2 w-full bg-red-500 rounded"
                        :style="`transform-origin: left; transform: scale(${
                            upload.progress / 100
                        },1)`"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import Sortable from "sortablejs";
import { getImageFileSrc, uploadFile } from "../lib/files";
import { del } from "../apis/http";
import { UploadingFile } from "../lib/UploadingFile";

export default {
    props: ["images", "upload-url", "title"],

    data() {
        return {
            hovering: false,
            sortable: null,
            uploads: [],
            deleting: [],
        };
    },

    computed: {
        uploading_files() {
            return this.uploads.filter((upload) => !upload.complete);
        },
    },

    mounted() {
        this.sortable = new Sortable(this.$refs.sortable, {
            onSort: () => this.$emit("sorted", this.sortable.toArray()),
        });
    },

    methods: {
        chooseFiles() {
            this.$refs.fileChooser.click();
        },

        handleFiles(ev) {
            this.hovering = false;
            const files = ev.target.files || ev.dataTransfer.files;
            [...files].forEach(this.processFile);
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
                const notImage = (type) => type.indexOf("image") !== 0;

                if (tooBig(file.size)) {
                    return reject(
                        `File size is greater than ${this.maxSize}MB`
                    );
                }
                if (notImage(file.type)) {
                    return reject(`File type ${file.type} is not recognized`);
                }
                resolve(file);
            });
        },

        upload(file) {
            const upload = new UploadingFile(file);
            this.uploads.push(upload);
            const setProgress = (progress) => upload.setProgress(progress);
            this.uploading = true;
            getImageFileSrc(file).then((src) => {
                if (this.uploading) {
                    this.src = src;
                }
            });

            uploadFile(file)
                .to(this.uploadUrl, "image", setProgress)
                .then(({ data }) => this.onSuccess(data, upload))
                .catch((response) => this.onError(response, upload))
                .then(() => (this.uploading = false));
        },

        removeImage(image) {
            this.deleting.push(image.id);
            del(image.delete_url)
                .then(() => {
                    this.$emit("image-cleared");
                })
                .catch(() => {
                    this.deleting = this.deleting.filter(
                        (id) => id !== image.id
                    );
                    this.$emit("clear-failed");
                });
        },

        onSuccess(response, upload) {
            upload.completed();
            this.$emit("uploaded");
        },

        onError({ status, data }, upload) {
            upload.completed();
            if (status === 422) {
                return this.$emit("upload-failed", data.errors.image[0]);
            }
            this.$emit("upload-failed", `Error uploading ${upload.name}`);
        },
    },
};
</script>
