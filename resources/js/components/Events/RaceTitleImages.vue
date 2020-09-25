<template v-if="race">
    <div>
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Race Images</p>
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
                        :initial-src="race.title_image.banner"
                        :upload-path="`/admin/races/${$route.params.race}/banner-image`"
                        :delete-path="`/admin/races/${$route.params.race}/banner-image`"
                        width="120"
                        height="64"
                        @uploaded="$store.dispatch('events/refreshEvents')"
                    ></image-upload>
                </div>
            </div>

            <div class="my-8 shadow rounded p-6">
                <p class="font-bold">Card Image</p>
                <p class="my-4 text-gray-600">
                    This image is used whenever an image is needed for the race
                    outside of the banner. It should be at least 1200px wide,
                    and 800px high. If the aspect ratio differs from 3:2 it will
                    be cropped from the center.
                </p>
                <div class="w-64 mx-auto">
                    <image-upload
                        :initial-src="race.title_image.card"
                        :upload-path="`/admin/races/${$route.params.race}/card-image`"
                        :delete-path="`/admin/races/${$route.params.race}/card-image`"
                        width="64"
                        height="42"
                        @uploaded="$store.dispatch('events/refreshEvents')"
                    ></image-upload>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import ImageUpload from "../ImageUpload";
export default {
    components: {
        ImageUpload,
    },

    computed: {
        race() {
            return this.$store.getters["events/currentEventActivityById"](
                this.$route.params.race
            );
        },
    },
};
</script>
