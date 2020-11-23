<template>
    <page v-if="pageEvent">
        <page-header
            :title="page_title"
            :breadcrumbs="breadcrumbs"
            :back-link="`/events/${$route.params.id}`"
        >
        </page-header>
        <div class="flex">
            <div class="w-64 h-64 pt-6 sticky top-0">
                <div>
                    <router-link
                        :to="`/events/${pageEvent.id}/edit/general`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >General Info</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${pageEvent.id}/edit/images`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Images</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${pageEvent.id}/edit/overview`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Writeup</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${pageEvent.id}/edit/activities`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Activities & Races</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${pageEvent.id}/edit/fees`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Fees</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${pageEvent.id}/edit/schedule`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Schedule</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${pageEvent.id}/edit/accommodation`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Accommodation</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${pageEvent.id}/edit/travel-routes`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Travel</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${pageEvent.id}/edit/sponsors`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Sponsors</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${pageEvent.id}/edit/galleries`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Galleries</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${pageEvent.id}/edit/videos`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Videos</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${pageEvent.id}/edit/people`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >People</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${pageEvent.id}/edit/publish`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Publish</router-link
                    >
                </div>
            </div>
            <div class="flex-1">
                <router-view :event="pageEvent"></router-view>
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
        page_title() {
            return this.pageEvent
                ? `Edit event:  ${this.pageEvent.name.en}`
                : "Edit event";
        },

        pageEvent() {
            return this.$store.state.events.current_page_event;
        },

        breadcrumbs() {
            return [
                { link: `/events/${this.$route.params.id}`, title: "Event" },
                { link: ``, title: "Edit" },
            ];
        },
    },

    mounted() {
        this.$store.dispatch("events/getCurrentPage", this.$route.params.id);

        this.$store
            .dispatch("events/fetchCategories")
            .catch(() =>
                notify.error({ message: "Unable to get event categories" })
            );
    },

    methods: {},
};
</script>
