<template>
    <div class="p-4 shadow">
        <p class="font-bold">{{ video.title.en }}</p>
        <p class="text-gray-600">{{ video.title.zh }}</p>
        <div class="w-80">
            <div
                class="w-full relative"
                v-html="embed_html"
                style="padding-bottom: 56.25%;"
            ></div>
        </div>
        <div v-show="!deleting">
            <div
                v-show="!show_delete_confirmation"
                class="mt-4 flex justify-end"
            >
                <add-youtube-video
                    class="mr-4"
                    :video="video"
                    @video-chosen="updateVideo"
                ></add-youtube-video>

                <button class="" @click="show_delete_confirmation = true">
                    Delete
                </button>
            </div>
            <div
                v-show="show_delete_confirmation"
                class="flex justify-end items-center mt-4"
            >
                <span>Are you sure?</span>
                <button
                    class="hover:text-red-500 text-blue-600 mx-6"
                    @click="deleteVideo"
                >
                    Yes
                </button>
                <button @click="show_delete_confirmation = false" class="">
                    No
                </button>
            </div>
        </div>
        <div v-show="deleting" class="mt-4 text-right">
            <span>Deleting...</span>
        </div>
    </div>
</template>

<script type="text/babel">
import AddYoutubeVideo from "./Events/AddYoutubeVideo";
import { notify } from "./Messaging/notify";
import { getYoutubeIFrame } from "../lib/videos";

export default {
    components: {
        AddYoutubeVideo,
    },

    props: ["video"],

    data() {
        return {
            deleting: false,
            show_delete_confirmation: false,
        };
    },

    computed: {
        embed_html() {
            return getYoutubeIFrame(this.video.video_id);
        },
    },

    methods: {
        deleteVideo() {
            this.deleting = true;

            this.$store
                .dispatch("events/deleteYoutubeVideo", this.video.id)
                .then(() => notify.success({ message: "Video deleted" }))
                .catch(() =>
                    notify.error({ message: "Failed to delete video" })
                )
                .then(() => (this.deleting = false));
        },

        updateVideo({ id, name }) {
            this.$emit("updated", {
                id: this.video.id,
                formData: {
                    video_id: id,
                    title: name,
                },
            });
        },
    },
};
</script>
