<template>
    <span>
        <button @click="showModal = true" :class="{ 'btn btn-dark': primary }">
            {{ video ? "Edit" : "Add Youtube Video" }}
        </button>
        <modal :show="showModal" @close="showModal = false">
            <div class="w-screen max-w-xl p-6">
                <p class="font-bold text-lg mb-6">Attach a Youtube video</p>
                <div v-if="!show_video">
                    <div>
                        <input-field
                            label="Youtube video url"
                            v-model="url"
                            help-text="Paste in a link to your youtube video"
                        ></input-field>
                    </div>
                    <div class="my-4 flex justify-end">
                        <button class="btn mr-4" @click="cancel">
                            Cancel
                        </button>
                        <button
                            :disabled="!url"
                            @click="show_video = true"
                            class="btn btn-dark"
                        >
                            Next
                        </button>
                    </div>
                </div>
                <div v-if="show_video">
                    <div class="flex justify-between items-center">
                        <div class="w-80 bg-gray-200 shadow">
                            <div
                                style="padding-bottom: 56.25%;"
                                class="relative w-full"
                                v-html="embed_html"
                            ></div>
                        </div>
                        <button
                            @click="rejectVideo"
                            class="btn shadow text-gray-600"
                        >
                            Change video
                        </button>
                    </div>

                    <div class="my-6">
                        <p class="font-bold">Name</p>
                        <p class="my-2 text-gray-600">
                            The name for this event
                        </p>
                        <div class="pl-6">
                            <input-field
                                class="mb-4"
                                label="English"
                                v-model="video_name.en"
                            ></input-field>
                            <input-field
                                class="my-4"
                                label="Chinese"
                                v-model="video_name.zh"
                            ></input-field>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button class="btn mr-4" @click="cancel">
                            Cancel
                        </button>
                        <button class="btn btn-dark" @click="useVideo">
                            Done
                        </button>
                    </div>
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
import Modal from "@dymantic/modal";
import InputField from "../Forms/InputField";
import getVideoId from "get-video-id";
export default {
    components: {
        Modal,
        InputField,
    },

    props: ["video", "primary"],

    data() {
        return {
            showModal: false,
            url: this.video
                ? `https://youtube.com/watch?v=${this.video.video_id}`
                : "",
            show_video: false,
            video_name: this.video ? this.video.title : { en: "", zh: "" },
        };
    },

    computed: {
        try_id() {
            return getVideoId(this.url).id;
        },

        embed_html() {
            return `<iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/${this.try_id}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
        },
    },

    mounted() {
        if (this.video) {
            this.show_video = true;
        }
    },

    methods: {
        useVideo() {
            this.$emit("video-chosen", {
                id: this.try_id,
                name: this.video_name,
            });
            this.resetState();
            this.showModal = false;
        },

        rejectVideo() {
            this.url = "";
            this.show_video = false;
        },

        cancel() {
            this.resetState();
            this.showModal = false;
        },

        resetState() {
            this.url = this.video
                ? `https://youtube.com/watch?v=${this.video.video_id}`
                : "";
            this.video_name = this.video
                ? this.video.title
                : { en: "", zh: "" };

            if (!this.video) {
                this.show_video = false;
            }
        },
    },
};
</script>
