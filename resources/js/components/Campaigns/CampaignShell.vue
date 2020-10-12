<template>
    <page v-if="campaign">
        <page-header
            :title="`Edit Race: ${campaign.title.en}`"
            colour="text-orange-600"
            :breadcrumbs="breadcrumbs"
        >
        </page-header>
        <div class="flex">
            <div class="w-64 h-64 pt-6 sticky top-0">
                <div class="mb-2">
                    <router-link
                        :to="`/campaigns/${$route.params.campaign}/show/general`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >General Info</router-link
                    >
                </div>

                <div class="mb-2">
                    <router-link
                        :to="`/campaigns/${$route.params.campaign}/show/images`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Images</router-link
                    >
                </div>

                <div class="mb-2">
                    <router-link
                        :to="`/campaigns/${$route.params.campaign}/show/videos`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Videos</router-link
                    >
                </div>

                <div class="mb-2">
                    <router-link
                        :to="`/campaigns/${$route.params.campaign}/show/content`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Content</router-link
                    >
                </div>

                <div class="mb-2">
                    <router-link
                        :to="`/campaigns/${$route.params.campaign}/show/event`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Event</router-link
                    >
                </div>

                <div class="mb-2">
                    <router-link
                        :to="`/campaigns/${$route.params.campaign}/show/promotion`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Promotion</router-link
                    >
                </div>

                <div class="mb-2">
                    <router-link
                        :to="`/campaigns/${$route.params.campaign}/show/articles`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Blog Articles</router-link
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
        campaign() {
            return this.$store.getters["campaigns/byId"](
                this.$route.params.campaign
            );
        },

        breadcrumbs() {
            return [
                {
                    link: `/campaigns`,
                    title: "Campaigns",
                },
                { link: "", title: this.campaign.title.en },
            ];
        },
    },

    mounted() {
        this.$store.dispatch("campaigns/fetchAll");
    },

    methods: {},
};
</script>
