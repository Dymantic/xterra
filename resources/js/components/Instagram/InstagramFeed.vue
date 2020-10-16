<template>
    <page>
        <page-header title="Instagram">
            <a :href="auth_url" class="btn btn-dark">{{
                has_auth ? "Re-authorize" : "Authorize"
            }}</a>
        </page-header>

        <div class="my-12" v-if="!has_auth">
            You need to grant the site access to your Instagram account so that
            it can fetch your feed.
        </div>

        <div class="my-12 max-w-4xl mx-auto flex justify-between flex-wrap">
            <div v-for="post in feed_images" class="w-32 h-32 m-4">
                <img :src="post.url" alt="" />
            </div>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import { notify } from "../Messaging/notify";
export default {
    components: {
        Page,
        PageHeader,
    },

    computed: {
        has_auth() {
            return this.$store.state.instagram.has_auth;
        },

        feed_images() {
            return this.$store.state.instagram.feed.filter(
                (post) => post.type !== "video"
            );
        },

        auth_url() {
            return this.$store.state.instagram.auth_url;
        },
    },

    created() {
        this.$store
            .dispatch("instagram/fetchInstagram")
            .catch(() =>
                notify.error({ message: "Failed to fetch instagram feed" })
            );
    },
};
</script>
