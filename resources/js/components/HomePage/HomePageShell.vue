<template>
    <page v-if="homePage">
        <page-header title="Home Page"> </page-header>
        <div class="flex">
            <div class="w-64 h-64 pt-6 sticky top-0">
                <div class="mb-2">
                    <router-link
                        to="/homepage/banner-image"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Banner Image</router-link
                    >
                </div>

                <div class="mb-2">
                    <router-link
                        to="/homepage/banner-video"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Banner Video</router-link
                    >
                </div>

                <div class="mb-2">
                    <router-link
                        to="/homepage/promo-video"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Promo Video</router-link
                    >
                </div>

                <div class="mb-2">
                    <router-link
                        to="/homepage/banner-text"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Banner Text</router-link
                    >
                </div>

                <div class="mb-2">
                    <router-link
                        to="/homepage/campaign"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Campaign</router-link
                    >
                </div>

                <div class="mb-2">
                    <router-link
                        to="/homepage/event"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Event</router-link
                    >
                </div>

                <div class="mb-2">
                    <router-link
                        to="/homepage/promotion"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Promotion</router-link
                    >
                </div>
            </div>
            <div class="flex-1">
                <router-view></router-view>
            </div>
        </div>
    </page>
</template>

<script type="text/babel">
import { notify } from "../Messaging/notify";

export default {
    data() {
        return {};
    },

    computed: {
        homePage() {
            return this.$store.state.homepage;
        },
    },

    mounted() {
        this.$store
            .dispatch("homepage/fetchHomePage")
            .catch(() =>
                notify.error({ message: "Unable to fetch home page info" })
            );
    },

    methods: {},
};
</script>
