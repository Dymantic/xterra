<template v-if="campaign">
    <div>
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Campaign Images</p>
        </div>
        <div>
            <div class="my-8 shadow rounded p-6">
                <p class="font-bold">Banner Image</p>
                <p class="my-4 text-gray-600">
                    This image is used as the main banner. It should be at least
                    2000px wide, and 1125px high. If the aspect ratio differs
                    from 2:1 it will be cropped from the center.
                </p>
                <div class="w-120 mx-auto">
                    <image-upload
                        :initial-src="campaign.banner_image.full"
                        :upload-path="`/admin/campaigns/${$route.params.campaign}/banner-image`"
                        :delete-path="`/admin/campaigns/${$route.params.campaign}/banner-image`"
                        width="120"
                        height="64"
                        @uploaded="$store.dispatch('campaigns/refresh')"
                        @invalid-file="handleInvalid"
                        @upload-failed="handleFailure"
                    ></image-upload>
                </div>
            </div>

            <div class="my-8 shadow rounded p-6">
                <p class="font-bold">Card Image</p>
                <p class="my-4 text-gray-600">
                    This image is used whenever an image is needed for the
                    campign outside of the banner. It should be at least 1200px
                    wide, and 800px high. If the aspect ratio differs from 3:2
                    it will be cropped from the center.
                </p>
                <div class="w-64 mx-auto">
                    <image-upload
                        :initial-src="campaign.title_image.web"
                        :upload-path="`/admin/campaigns/${$route.params.campaign}/title-image`"
                        :delete-path="`/admin/campaigns/${$route.params.campaign}/title-image`"
                        width="64"
                        height="42"
                        @uploaded="$store.dispatch('campaigns/refresh')"
                        @invalid-file="handleInvalid"
                        @upload-failed="handleFailure"
                    ></image-upload>
                </div>
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
        campaign() {
            return this.$store.getters["campaigns/byId"](
                this.$route.params.campaign
            );
        },
    },

    methods: {
        handleInvalid(message) {
            notify.warn({ message });
        },

        handleFailure() {
            notify.error({ message: "Unable to set title image" });
        },
    },
};
</script>
