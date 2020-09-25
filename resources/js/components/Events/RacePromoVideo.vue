<template>
    <div v-if="race">
        <div class="flex justify-between items-center mb-12">
            <p class="font-bold text-lg">Race Promo Video</p>
            <div class="flex justify-end items-center">
                <add-youtube-video
                    @video-chosen="addVideo"
                    :primary="true"
                ></add-youtube-video>
            </div>
        </div>
        <div class="flex flex-wrap items-start" v-show="race.video">
            <embedded-video
                :video="race.video"
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
export default {
    components: {
        AddYoutubeVideo,
        EmbeddedVideo,
    },

    computed: {
        race() {
            return this.$store.getters["events/currentEventActivityById"](
                this.$route.params.race
            );
        },
    },

    methods: {
        addVideo({ id, name }) {
            this.$store
                .dispatch("events/saveRacePromoVideo", {
                    race_id: this.$route.params.race,
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
