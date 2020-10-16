<template>
    <div v-if="homePage">
        <div class="flex justify-between mb-12">
            <p class="font-bold text-lg">Banner Video</p>
            <div class="flex justify-end"></div>
        </div>

        <div>
            <single-file-upload
                :max-size="30"
                class="border-t border-gray-300 pt-2"
                upload-path="/admin/home-page/banner-video"
                delete-path="/admin/home-page/banner-video"
                :download-path="homePage.banner_video"
                filename="home_page_banner_video"
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

            <div class="my-8" v-if="homePage.banner_video">
                <video
                    :src="homePage.banner_video"
                    muted
                    autoplay
                    loop
                    class="max-w-md mx-auto"
                ></video>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import SingleFileUpload from "../SingleFileUpload";
import { notify } from "../Messaging/notify";
export default {
    components: { SingleFileUpload },

    computed: {
        homePage() {
            return this.$store.state.homepage.homepage;
        },
    },

    methods: {
        handleUpload() {
            this.$store.dispatch("homepage/refreshHomePage");
        },

        handleUploadError() {
            notify.error({ message: "Failed to upload video" });
        },

        handleInvalid() {
            notify.warn({ message: "Your file is not an accepted video file" });
        },

        handleCleared() {
            this.$store.dispatch("homepage/refreshHomePage");
        },

        handleClearError() {
            notify.error({ message: "Failed to delete video" });
        },
    },
};
</script>
