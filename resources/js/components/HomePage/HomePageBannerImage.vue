<template>
    <div v-if="homePage">
        <div class="flex justify-between mb-12">
            <p class="font-bold text-lg">Banner Image</p>
            <div class="flex justify-end"></div>
        </div>

        <div class="my-8 shadow rounded p-6">
            <p class="my-4 text-gray-600">
                This image is used as the main banner. It should be at least
                2000px wide, and 1125px high. If the aspect ratio differs from
                16:9 it will be cropped from the center.
            </p>
            <div class="w-120 mx-auto">
                <image-upload
                    :initial-src="homePage.banner_image.full"
                    :upload-path="`/admin/home-page/banner-image`"
                    :delete-path="`/admin/home-page/banner-image`"
                    width="120"
                    height="64"
                    @uploaded="$store.dispatch('homepage/fetchHomePage')"
                    @invalid-file="handleInvalid"
                    @upload-failed="handleError"
                ></image-upload>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import ImageUpload from "../ImageUpload";
import { notify } from "../Messaging/notify";
export default {
    components: {
        ImageUpload,
    },

    computed: {
        homePage() {
            return this.$store.state.homepage.homepage;
        },
    },

    methods: {
        handleInvalid(message) {
            notify.warn({ message });
        },

        handleError() {
            notify.error({ message: "Failed to save image" });
        },
    },
};
</script>
