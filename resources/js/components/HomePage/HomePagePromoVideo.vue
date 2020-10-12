<template>
    <div v-if="homePage">
        <div class="flex justify-between mb-12">
            <p class="font-bold text-lg">Homepage Promo Video</p>
            <div class="flex justify-end">
                <delete-home-page-promo-video
                    v-show="homePage.promo_video"
                    class="mr-4"
                ></delete-home-page-promo-video>
                <add-youtube-video
                    @video-chosen="addVideo"
                    :primary="true"
                ></add-youtube-video>
            </div>
        </div>

        <p class="my-12 text-gray-600 max-w-lg">
            This is for the full promotional video (NOT the banner video). It
            should be a Youtube video.
        </p>

        <div class="my-12" v-show="homePage.promo_video">
            <embedded-video
                :video="homePage.promo_video"
                class="my-8"
                @updated="handleUpdate"
                :cannot-delete="true"
            ></embedded-video>
        </div>
    </div>
</template>

<script type="text/babel">
import AddYoutubeVideo from "../Events/AddYoutubeVideo";
import EmbeddedVideo from "../EmbeddedVideo";
import DeleteHomePagePromoVideo from "./DeleteHomePagePromoVideo";
import { notify } from "../Messaging/notify";
export default {
    components: {
        AddYoutubeVideo,
        EmbeddedVideo,
        DeleteHomePagePromoVideo,
    },
    computed: {
        homePage() {
            return this.$store.state.homepage.homepage;
        },
    },

    methods: {
        addVideo({ id, name }) {
            this.$store
                .dispatch("homepage/attachPromoVideo", {
                    video_id: id,
                    title: name,
                })
                .then(() => notify.success({ message: "Video added" }))
                .catch(this.onError);
        },

        onError({ status, data }) {
            if (status === 422) {
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
