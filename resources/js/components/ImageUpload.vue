<template>
    <div :class="widthClass">
        <div
            class="overflow-hidden bg-gray-200"
            :class="pictureClasses"
            @click="chooseFile"
            @drop.prevent="handleFiles"
            @dragenter.prevent="hovering = true"
            @dragover.prevent="hovering = true"
            @dragleave.prevent="hovering = false"
        >
            <img
                :src="src"
                alt=""
                class="w-full h-full"
                :class="{ 'object-cover': !contain, 'object-contain': contain }"
            />
        </div>
        <div class="py-2" v-show="uploading">
            <div class="h-2 w-full rounded bg-gray-400">
                <div
                    class="h-2 w-full bg-red-500 rounded"
                    :style="`transform-origin: left; transform: scale(${
                        progress / 100
                    },1)`"
                ></div>
            </div>
        </div>
        <div class="flex justify-between py-2" v-show="!uploading">
            <p class="text-xs">Click image to upload</p>
            <button
                v-if="deletePath"
                @click="clearImage"
                type="button"
                class="text-xs font-semibold hover:text-blue-600 shadow p-1"
            >
                Clear
            </button>
        </div>
        <input type="file" class="hidden" ref="fileInput" @input="handleFile" />
    </div>
</template>

<script type="text/babel">
import { getImageFileSrc, uploadFile } from "../lib/files";
import { del } from "../apis/http";

export default {
    props: {
        width: String,
        height: String,
        round: Boolean,
        "initial-src": String,
        "upload-path": String,
        "delete-path": String,
        "max-size": {
            type: Number,
            default: 15,
        },
        contain: {
            type: Boolean,
            default: false,
        },
    },

    data() {
        return {
            hovering: false,
            uploading: false,
            progress: null,
            src: this.initialSrc,
            last_confirmed_src: this.initialSrc,
            widths: {
                12: "w-12",
                24: "w-24",
                32: "w-32",
                40: "w-40",
                48: "w-48",
                64: "w-64",
                80: "w-80",
                120: "w-120",
            },
            heights: {
                12: "h-12",
                24: "h-24",
                32: "h-32",
                40: "h-40",
                48: "h-48",
                60: "h-60",
                64: "h-64",
                80: "h-80",
            },
            defaultSrc: "/images/default_image.svg",
        };
    },

    computed: {
        pictureClasses() {
            const dims = `${this.widths[this.width] || "w-48"} ${
                this.heights[this.height] || "h-48"
            }`;

            const round = this.round ? "rounded-full" : "";
            const border = this.hovering ? "border-4 border-blue-600" : "";

            return [dims, round, border].filter((cl) => cl !== "").join(" ");
        },

        widthClass() {
            return `${this.widths[this.width] || "w-48"}`;
        },

        maxFileSize() {
            return this.maxSize * 1000 * 1024;
        },
    },

    methods: {
        chooseFile() {
            this.$refs.fileInput.click();
        },

        handleFiles(ev) {
            this.hovering = false;
            const files = ev.target.files || ev.dataTransfer.files;
            this.processFile(files[0]);
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
            const setProgress = (progress) => (this.progress = progress);
            this.uploading = true;
            getImageFileSrc(file).then((src) => {
                if (this.uploading) {
                    this.src = src;
                }
            });

            uploadFile(file)
                .to(this.uploadPath, "image", setProgress)
                .then((data) => this.onSuccess(data))
                .catch(this.onError)
                .then(() => (this.uploading = false));
        },

        clearImage() {
            del(this.deletePath)
                .then(() => {
                    this.src = this.defaultSrc;
                    this.$emit("cleared");
                })
                .catch(() => this.$emit("clear-failed"));
        },

        onSuccess(response) {
            this.$emit("uploaded");
            if (response && response.src) {
                this.last_confirmed_src = response.src;
                this.src = response.src;
            }
        },

        onError({ status, data }) {
            this.src = this.last_confirmed_src;
            if (status === 422) {
                return this.$emit("invalid-file", data.errors.image[0]);
            }
            this.$emit("upload-failed", "Server error uploading image");
        },
    },
};
</script>
