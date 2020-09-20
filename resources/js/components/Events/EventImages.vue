<template v-if="event">
    <div>
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Event Images</p>
        </div>
        <div>
            <div class="my-8 shadow rounded p-6">
                <p class="font-bold">Banner Image</p>
                <p class="my-4 text-gray-600">
                    This image is used as the main banner. It should be at least
                    2000px wide, and 1000px high. If the aspect ratio differs
                    from 2:1 it will be cropped from the center.
                </p>
                <div class="w-120 mx-auto">
                    <image-upload
                        :initial-src="event.banner_image.banner"
                        :upload-path="`/admin/events/${$route.params.id}/banner-image`"
                        :delete-path="`/admin/events/${$route.params.id}/banner-image`"
                        width="120"
                        height="60"
                        @uploaded="$store.dispatch('events/refreshEvents')"
                    ></image-upload>
                </div>
            </div>

            <div class="my-8 shadow rounded p-6">
                <p class="font-bold">Card Image</p>
                <p class="my-4 text-gray-600">
                    This image is used whenever an image is needed for the event
                    outside of the banner. It should be at least 1200px wide,
                    and 800px high. If the aspect ratio differs from 3:2 it will
                    be cropped from the center.
                </p>
                <div class="w-64 mx-auto">
                    <image-upload
                        :initial-src="event.card_image.web"
                        :upload-path="`/admin/events/${$route.params.id}/card-image`"
                        :delete-path="`/admin/events/${$route.params.id}/card-image`"
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
        event() {
            return this.$store.state.events.current_page_event;
        },
    },
};
</script>
