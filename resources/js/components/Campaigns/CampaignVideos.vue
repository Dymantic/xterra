<template>
    <div>
        <div class="flex justify-between mb-12">
            <p class="font-bold text-lg">Campaign Videos</p>
            <div class="flex justify-end"></div>
        </div>

        <div class="my-12">
            <div class="flex justify-between mb-8">
                <p class="font-bold text-lg">Banner Video</p>
                <div class="flex justify-end"></div>
            </div>

            <single-file-upload
                :max-size="30"
                class="border-t border-gray-300 pt-2"
                :upload-path="`/admin/campaigns/${$route.params.campaign}/banner-video`"
                :delete-path="`/admin/campaigns/${$route.params.campaign}/banner-video`"
                :download-path="campaign.banner_video"
                filename="campaign_banner_video"
                name="video"
                prompt="Upload the banner video for this campaign"
                @uploaded="handleUpload"
                @upload-failed="handleUploadError"
                @invalid-file="handleInvalid"
                @cleared="handleCleared"
                @clear-failed="handleClearError"
            ></single-file-upload>

            <p class="my-6 text-gray-600 max-w-lg">
                This is for the banner video. File size is very important here,
                so the video should be as short as possible (6-7seconds),
                compressed and optimized and not a super high resolution. The
                video will always be muted, so it would be best if the
                soundtrack could be removed entirely.
            </p>

            <div class="my-8" v-if="campaign.banner_video">
                <video
                    :src="campaign.banner_video"
                    muted
                    autoplay
                    loop
                    class="max-w-md mx-auto"
                ></video>
            </div>
        </div>

        <div class="my-12">
            <div class="flex justify-between mb-8">
                <p class="font-bold text-lg">Promo Video</p>
                <div class="flex justify-end">
                    <delete-campaign-promo-video
                        :campaign-id="$route.params.campaign"
                        class="mr-4"
                    ></delete-campaign-promo-video>
                    <add-youtube-video
                        @video-chosen="addVideo"
                        :primary="true"
                    ></add-youtube-video>
                </div>
            </div>
            <p class="my-6 text-gray-600 max-w-lg">
                This is for the full promotional video (NOT the banner video).
                It should be a Youtube video.
            </p>
            <div v-show="campaign.promo_video">
                <embedded-video
                    :video="campaign.promo_video"
                    class="my-8"
                    @updated="handleUpdate"
                    :cannot-delete="true"
                ></embedded-video>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import AddYoutubeVideo from "../Events/AddYoutubeVideo";
import { notify } from "../Messaging/notify";
import EmbeddedVideo from "../EmbeddedVideo";
import SingleFileUpload from "../SingleFileUpload";
import DeleteCampaignPromoVideo from "./DeleteCampaignPromoVideo";
export default {
    components: {
        DeleteCampaignPromoVideo,
        SingleFileUpload,
        EmbeddedVideo,
        AddYoutubeVideo,
    },

    computed: {
        campaign() {
            return this.$store.getters["campaigns/byId"](
                this.$route.params.campaign
            );
        },
    },

    methods: {
        addVideo({ id, name }) {
            this.$store
                .dispatch("campaigns/attachPromoVideo", {
                    campaign_id: this.$route.params.campaign,
                    formData: {
                        video_id: id,
                        title: name,
                    },
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

        handleUpload() {
            this.$store.dispatch("campaigns/refresh");
        },

        handleInvalid(message) {
            notify.warn({ message: "That is not a valid video file" });
        },

        handleCleared() {
            this.$store.dispatch("campaigns/refresh");
        },

        handleClearError() {
            notify.error({ message: "Failed to clear video" });
        },

        handleUploadError() {
            notify.error({ message: "Failed to upload video" });
        },
    },
};
</script>
