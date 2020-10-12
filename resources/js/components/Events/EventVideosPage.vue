<template>
    <div>
        <div class="flex justify-between items-center mb-12">
            <p class="font-bold text-lg">Event Videos</p>
            <div class="flex justify-end items-center"></div>
        </div>

        <div class="my-12">
            <div class="flex justify-between mb-8">
                <p class="font-bold text-lg">Promo Video</p>
                <div class="flex justify-end">
                    <delete-event-promo-video
                        :event-id="$route.params.id"
                        class="mr-4"
                    ></delete-event-promo-video>
                    <add-youtube-video
                        @video-chosen="addPromoVideo"
                        :primary="true"
                    ></add-youtube-video>
                </div>
            </div>
            <p class="my-6 text-gray-600 max-w-lg">
                This is for the full promotional video (NOT the banner video).
                It should be a Youtube video.
            </p>
            <div v-show="event.promo_video">
                <embedded-video
                    :video="event.promo_video"
                    class="my-8"
                    @updated="handleUpdate"
                    :cannot-delete="true"
                ></embedded-video>
            </div>
        </div>

        <div class="my-12">
            <div class="flex justify-between mb-8">
                <p class="font-bold text-lg">Highlight Videos</p>
                <div class="flex justify-end">
                    <add-youtube-video
                        @video-chosen="addVideo"
                        :primary="false"
                    ></add-youtube-video>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-start">
            <embedded-video
                v-for="video in videos"
                :key="video.id"
                :video="video"
                class="my-8"
                @updated="handleUpdate"
            ></embedded-video>
        </div>
    </div>
</template>

<script type="text/babel">
import AddYoutubeVideo from "./AddYoutubeVideo";
import EmbeddedVideo from "../EmbeddedVideo";
import { notify } from "../Messaging/notify";
import DeleteEventPromoVideo from "./DeleteEventPromoVideo";
export default {
    components: {
        DeleteEventPromoVideo,
        AddYoutubeVideo,
        EmbeddedVideo,
    },

    computed: {
        event() {
            return this.$store.state.events.current_page_event;
        },

        videos() {
            return this.$store.getters["events/currentEventVideos"];
        },
    },

    methods: {
        addVideo({ id, name }) {
            this.$store
                .dispatch("events/attachYoutubeVideo", {
                    event_id: this.$route.params.id,
                    formData: {
                        video_id: id,
                        title: name,
                    },
                })
                .then(() => notify.success({ message: "Video added" }))
                .catch(this.onError);
        },

        addPromoVideo({ id, name }) {
            this.$store
                .dispatch("events/attachPromoVideo", {
                    event_id: this.$route.params.id,
                    formData: {
                        video_id: id,
                        title: name,
                    },
                })
                .then(() => notify.success({ message: "Video added" }))
                .catch(this.onError);
        },

        onError({ status, data }) {
            if (status === 4222) {
                return notify.warn({ message: data.errors[0][0] });
            }
            notify.error({ message: "Failed to attach video" });
        },

        handleUpdate(video_data) {
            this.$store
                .dispatch("events/updateYoutubeVideo", video_data)
                .then(() => notify.success({ message: "Video updated" }))
                .catch(this.onError);
        },
    },
};
</script>
