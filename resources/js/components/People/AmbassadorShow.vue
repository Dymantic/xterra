<template>
    <page v-if="ambassador">
        <page-header :title="ambassador.name[lang]">
            <router-link
                :to="`/ambassadors/${ambassador.id}/edit`"
                class="btn btn-dark"
                >Edit</router-link
            >
        </page-header>

        <language-selector v-model="lang" class="my-12"></language-selector>

        <ambassador-publisher
            :ambassador="ambassador"
            class="my-12 p-6 shadow rounded-lg"
        ></ambassador-publisher>

        <div class="my-12 p-6 shadow rounded-lg flex justify-between">
            <div class="mr-8 max-w-sm admin-edited">
                <p class="font-bold text-lg mb-2">About</p>
                <div v-html="ambassador.about[lang]"></div>
            </div>
            <div>
                <image-upload
                    :initial-src="ambassador.profile_pic.web"
                    :upload-path="`/admin/ambassadors/${ambassador.id}/profile-pic`"
                    :delete-path="`/admin/ambassadors/${ambassador.id}/profile-pic`"
                    width="64"
                    height="42"
                    @uploaded="$store.dispatch('ambassadors/refresh')"
                    @invalid-file="handleInvalid"
                    @upload-failed="handleFailure"
                ></image-upload>
            </div>
        </div>

        <social-links
            class="my-12 p-6 shadow rounded-lg"
            :links="ambassador.social_links"
        ></social-links>

        <div class="my-12 admin-edited">
            <p class="font-bold text-lg mb-2">Achievements</p>
            <div v-html="ambassador.achievements[lang]"></div>
        </div>

        <div class="my-12 admin-edited">
            <p class="font-bold text-lg mb-2">Work with XTERRA</p>
            <div v-html="ambassador.collaboration[lang]"></div>
        </div>

        <div class="my-12 admin-edited">
            <p class="font-bold text-lg mb-2">Philosophy</p>
            <div v-html="ambassador.philosophy[lang]"></div>
        </div>

        <div class="my-12">
            <div
                class="flex justify-between items-center border-b border-gray-300 pb-2 mb-8"
            >
                <p class="text-lg font-bold">Videos</p>
                <add-youtube-video
                    @video-chosen="addVideo"
                    primary="true"
                ></add-youtube-video>
            </div>
            <div class="flex flex-wrap">
                <embedded-video
                    v-for="video in ambassador.videos"
                    :key="video.id"
                    :video="video"
                    class="m-8 max-w-sm"
                    @updated="handleUpdate"
                    @deleted="$store.dispatch('ambassadors/refresh')"
                ></embedded-video>
            </div>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import ImageUpload from "../ImageUpload";
import { notify } from "../Messaging/notify";
import LanguageSelector from "../LanguageSelector";
import AmbassadorPublisher from "./AmbassadorPublisher";
import AddYoutubeVideo from "../Events/AddYoutubeVideo";
import EmbeddedVideo from "../EmbeddedVideo";
import SocialLinks from "./SocialLinks";
export default {
    components: {
        SocialLinks,
        AddYoutubeVideo,
        AmbassadorPublisher,
        LanguageSelector,
        Page,
        PageHeader,
        ImageUpload,
        EmbeddedVideo,
    },

    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        ambassador() {
            return this.$store.getters["ambassadors/byId"](
                this.$route.params.ambassador
            );
        },
    },

    mounted() {
        this.$store.dispatch("ambassadors/fetch");
    },

    methods: {
        handleInvalid(message) {
            notify.warn({ message });
        },

        handleFailure() {
            notify.error({ message: "Failed to upload profile pic." });
        },

        addVideo({ id, name }) {
            this.$store
                .dispatch("ambassadors/attachVideo", {
                    ambassador_id: this.ambassador.id,
                    formData: {
                        video_id: id,
                        title: name,
                    },
                })
                .catch(() =>
                    notify.error({ message: "Failed to attach video" })
                );
        },

        handleUpdate(video_data) {
            this.$store
                .dispatch("events/updateYoutubeVideo", video_data)
                .then(() => notify.success({ message: "Video updated" }))
                .catch(() =>
                    notify.error({ message: "Failed to update video" })
                );
        },
    },
};
</script>
