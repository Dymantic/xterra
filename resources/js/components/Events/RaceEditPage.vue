<template>
    <page v-if="race">
        <page-header
            :title="`Edit Race: ${race.name.en}`"
            colour="text-teal-600"
            :breadcrumbs="breadcrumbs"
            :back-link="`/events/${$route.params.event}/edit/activities`"
        >
        </page-header>
        <div class="flex">
            <div class="w-64 h-64 pt-6 sticky top-0">
                <div>
                    <router-link
                        :to="`/events/${$route.params.event}/races/${race.id}/edit/general`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >General Info</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${$route.params.event}/races/${race.id}/edit/images`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Images</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${$route.params.event}/races/${race.id}/edit/description/show`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Writeup</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${$route.params.event}/races/${race.id}/edit/courses`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Courses</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${$route.params.event}/races/${race.id}/edit/prizes`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Prizes</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${$route.params.event}/races/${race.id}/edit/prize-notes`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Prize Notes</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${$route.params.event}/races/${race.id}/edit/fees`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Fees</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${$route.params.event}/races/${race.id}/edit/fees-notes`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Fees Notes</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${$route.params.event}/races/${race.id}/edit/schedule`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Schedule</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${$route.params.event}/races/${race.id}/edit/schedule-notes`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Schedule Notes</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${$route.params.event}/races/${race.id}/edit/rules/show`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Race Rules</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${$route.params.event}/races/${race.id}/edit/info/show`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Race Info</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${$route.params.event}/races/${race.id}/edit/video`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Promo Video</router-link
                    >
                </div>

                <div class="my-2">
                    <router-link
                        :to="`/events/${$route.params.event}/races/${race.id}/edit/files`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Files</router-link
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
        race() {
            return this.$store.getters["events/currentEventActivityById"](
                this.$route.params.race
            );
        },

        breadcrumbs() {
            return [
                {
                    link: `/events/${this.$route.params.event}`,
                    title: "Event",
                },
                {
                    link: `/events/${this.$route.params.event}/edit/activities`,
                    title: "Activities & Races",
                },
                { link: "", title: "Mountain Madness" },
            ];
        },
    },

    mounted() {
        this.$store.dispatch("events/fetchAll");
        this.$store.dispatch("events/getCurrentPage", this.$route.params.event);
        this.$store
            .dispatch("events/fetchCategories")
            .catch(() =>
                notify.error({ message: "Unable to get event categories" })
            );
    },

    methods: {},
};
</script>
