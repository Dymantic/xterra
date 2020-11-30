<template>
    <page v-if="coach">
        <page-header :title="coach.name[lang]">
            <router-link :to="`/coaches/${coach.id}/edit`" class="btn btn-dark"
                >Edit
            </router-link>
        </page-header>

        <language-selector v-model="lang" class="my-12"></language-selector>

        <coach-publisher
            :coach="coach"
            class="my-12 p-6 shadow rounded-lg"
        ></coach-publisher>

        <div class="my-12 p-6 shadow rounded-lg flex justify-between">
            <div class="mr-8 max-w-sm admin-edited">
                <p class="font-bold text-lg mb-2">Contact</p>
                <p>
                    <a
                        target="_blank"
                        rel="nofollow"
                        :href="`mailto:${coach.email}`"
                        >{{ coach.email }}</a
                    >
                </p>
                <p>
                    <a target="_blank" rel="nofollow" :href="coach.website">{{
                        coach.website
                    }}</a>
                </p>
                <p>{{ coach.phone }}</p>
                <p>{{ coach.line }}</p>
            </div>
            <div>
                <image-upload
                    :initial-src="coach.profile_pic.web"
                    :upload-path="`/admin/coaches/${coach.id}/profile-pic`"
                    :delete-path="`/admin/coaches/${coach.id}/profile-pic`"
                    width="64"
                    height="42"
                    @uploaded="$store.dispatch('coaches/refresh')"
                    @invalid-file="handleInvalid"
                    @upload-failed="handleFailure"
                ></image-upload>
            </div>
        </div>

        <social-links
            class="my-12 p-6 shadow rounded-lg"
            :links="coach.social_links"
        ></social-links>

        <div class="my-12 admin-edited">
            <p class="font-bold text-lg mb-2">High Level Experience</p>
            <div v-html="coach.experience[lang]"></div>
        </div>

        <div class="my-12 admin-edited">
            <p class="font-bold text-lg mb-2">Certifications</p>
            <div v-html="coach.certifications[lang]"></div>
        </div>

        <div class="my-12 admin-edited">
            <p class="font-bold text-lg mb-2">Philosophy</p>
            <div v-html="coach.philosophy[lang]"></div>
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
                    v-for="video in coach.videos"
                    :key="video.id"
                    :video="video"
                    class="m-8 max-w-sm"
                    @updated="handleUpdate"
                    @deleted="$store.dispatch('coaches/refresh')"
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
import CoachPublisher from "./CoachPublisher";
import AddYoutubeVideo from "../Events/AddYoutubeVideo";
import EmbeddedVideo from "../EmbeddedVideo";
import SocialLinks from "./SocialLinks";

export default {
    components: {
        AddYoutubeVideo,
        LanguageSelector,
        CoachPublisher,
        Page,
        PageHeader,
        ImageUpload,
        EmbeddedVideo,
        SocialLinks,
    },

    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        coach() {
            return this.$store.getters["coaches/byId"](
                this.$route.params.coach
            );
        },
    },

    mounted() {
        this.$store.dispatch("coaches/fetch");
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
                .dispatch("coaches/attachVideo", {
                    coach_id: this.coach.id,
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
