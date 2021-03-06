<template>
    <page v-if="pageEvent">
        <page-header :title="pageEvent.name.en">
            <router-link
                :to="`/events/${pageEvent.id}/edit/general`"
                class="btn btn-dark"
                >Edit</router-link
            >
        </page-header>
        <language-selector v-model="lang"></language-selector>
        <div>
            <div class="flex">
                <p class="text-3xl font-bold">{{ pageEvent.name[lang] }}</p>
                <p class="pl-3 text-gray-600 text-3xl" v-if="pageEvent.dates">
                    | {{ pageEvent.dates }}
                </p>
            </div>

            <event-category-icons
                class="my-2"
                :categories="pageEvent.categories"
                colour="text-black"
            ></event-category-icons>

            <p class="text-xl text-gray-600 uppercase">
                {{ pageEvent.location[lang] }}
            </p>
            <p class="font-bold">{{ pageEvent.venue_name[lang] }}</p>
            <div class="flex">
                <p>{{ pageEvent.venue_address[lang] }}</p>
                <a
                    :href="pageEvent.venue_maplink"
                    target="_blank"
                    class="text-blue-600 hover:underline text-sm ml-4"
                    >(See map)</a
                >
            </div>
            <p class="mt-2">
                <strong>Registration at: </strong
                >{{ pageEvent.registration_link }}
            </p>
        </div>

        <div class="my-12 max-w-2xl" v-html="pageEvent.overview[lang]"></div>

        <div class="mb-6">
            <p class="uppercase text-lg text-red-700">Races</p>
            <div v-for="race in event_races" :key="race.id" class="my-4">
                <p class="font-bold text-lg">{{ race.name[lang] }}</p>
                <div class="flex items-center">
                    <category-colour-label
                        :category="race.category"
                    ></category-colour-label>
                    <p class="ml-3 text-gray-600">{{ race.distance[lang] }}</p>
                    <router-link
                        :to="`/events/${$route.params.id}/races/${race.id}/edit/general`"
                        class="mx-4 text-gray-600 hover:text-blue-600 font-bold"
                        >Edit</router-link
                    >
                </div>
            </div>
        </div>

        <div class="mb-12">
            <p class="uppercase text-lg text-red-700">Activities</p>
            <div
                v-for="activity in event_activities"
                :key="activity.id"
                class="my-4"
            >
                <p class="font-bold text-lg">{{ activity.name[lang] }}</p>
                <div class="flex items-center">
                    <category-colour-label
                        :category="activity.category"
                    ></category-colour-label>
                    <p>{{ activity.distance[lang] }}</p>
                    <router-link
                        :to="`/events/${$route.params.id}/races/${activity.id}/edit/general`"
                        class="mx-4 text-gray-600 hover:text-blue-600 font-bold"
                        >Edit</router-link
                    >
                </div>
            </div>
        </div>

        <div>
            <p class="uppercase text-lg text-red-700">Schedule</p>
            <div v-for="day in pageEvent.schedule" :key="day.day" class="my-4">
                <p class="font-bold text-lg">Day {{ day.day }}</p>
                <table class="w-full max-w-lg border border-gray-400">
                    <thead>
                        <tr class="text-left border-b border-gray-400">
                            <th class="p-2">Time of Day</th>
                            <th class="p-2">Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(entry, index) in day.entries"
                            :class="{ 'bg-blue-100': index % 2 === 1 }"
                        >
                            <td class="px-2 py-1">
                                {{ entry.time_of_day[lang] }}
                            </td>
                            <td class="px-2 py-1">
                                <p>{{ entry.item[lang] }}</p>
                                <div
                                    class="flex text-sm items-center text-gray-600"
                                >
                                    <location-icon
                                        class="h-5 mr-2"
                                    ></location-icon>
                                    <p>{{ entry.location[lang] }}</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="my-12">
            <p class="uppercase text-lg text-red-700 mb-4">Entry Fees</p>
            <table class="w-full max-w-lg border border-gray-400">
                <thead>
                    <tr class="text-left border-b border-gray-400">
                        <th class="p-2">Entrance</th>
                        <th class="p-2">Fee</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(fee, index) in pageEvent.fees"
                        :class="{ 'bg-blue-100': index % 2 === 1 }"
                    >
                        <td class="px-2 py-1">
                            {{ fee.category[lang] }}
                        </td>
                        <td class="px-2 py-1">{{ fee.fee }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="my-12">
            <p class="uppercase text-lg text-red-700 mb-4">Accommodation</p>
            <div
                v-for="place in pageEvent.accommodation"
                :key="place.id"
                class="my-6 max-w-xl"
            >
                <p class="font-bold">{{ place.name[lang] }}</p>
                <div class="flex justify-between pb-1 border-b border-gray-300">
                    <p class="text-sm">{{ place.email }}</p>
                    <p class="text-sm">{{ place.phone }}</p>
                    <p class="text-sm">{{ place.link }}</p>
                </div>
                <p class="mt-4 text-sm max-w-md">
                    {{ place.description[lang] }}
                </p>
            </div>
        </div>

        <div>
            <p class="uppercase text-lg text-red-700 mb-4">Travel Routes</p>
            <div v-if="pageEvent.travel_guide">
                <a
                    :href="pageEvent.travel_guide"
                    class="inline-flex items-center shadow px-6 py-2 font-bold text-gray-600 hover:text-blue-600 rounded"
                >
                    <file-icon class="h-5 mr-6 text-gray-600"></file-icon>
                    <span>Travel Guide</span>
                </a>
            </div>
            <div
                v-for="route in pageEvent.travel_routes"
                :key="route.id"
                class="my-6 max-w-xl flex justify-between p-4 shadow rounded"
            >
                <div class="pr-8">
                    <p class="font-bold">{{ route.name[lang] }}</p>
                    <p class="text-sm mt-2">{{ route.description[lang] }}</p>
                </div>
                <div>
                    <div class="w-32" v-if="route.image">
                        <img :src="route.image" alt="" />
                    </div>
                </div>
            </div>
        </div>

        <div class="my-12">
            <p class="uppercase text-lg text-red-700 mb-4">Galleries</p>
            <event-gallery-card
                v-for="gallery in pageEvent.galleries"
                :key="gallery.id"
                :gallery="gallery"
                class="my-6 max-w-2xl p-4 shadow"
            >
            </event-gallery-card>
        </div>

        <div class="my-12">
            <p class="uppercase text-lg text-red-700 mb-4">Videos</p>
            <div v-for="video in pageEvent.videos" :key="video.id">
                <p class="font-bold">{{ video.title[lang] }}</p>
                <div class="max-w-sm p-4 rounded-lg">
                    <div
                        class="w-full relative"
                        style="padding-bottom: 56.25%;"
                        v-html="videoIframe(video.video_id)"
                    ></div>
                </div>
            </div>
        </div>
    </page>
</template>

<script type="text/babel">
import LanguageSelector from "../LanguageSelector";
import EventGalleryCard from "./EventGalleryCard";
import FileIcon from "../Icons/FileIcon";
import LocationIcon from "../Icons/LocationIcon";
import EventCategoryIcons from "./EventCategoryIcons";
import CategoryColourLabel from "./CategoryColourLabel";
import { notify } from "../Messaging/notify";
import { getYoutubeIFrame } from "../../lib/videos";

export default {
    components: {
        LanguageSelector,
        EventCategoryIcons,
        EventGalleryCard,
        FileIcon,
        LocationIcon,
        CategoryColourLabel,
    },

    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        pageEvent() {
            return this.$store.state.events.current_page_event;
        },

        event_activities() {
            return this.pageEvent
                ? this.pageEvent.activities.filter((act) => !act.is_race)
                : [];
        },

        event_races() {
            return this.pageEvent
                ? this.pageEvent.activities.filter((act) => act.is_race)
                : [];
        },
    },

    mounted() {
        this.$store
            .dispatch("events/getCurrentPage", this.$route.params.id)
            .catch(notify.error);
    },

    methods: {
        videoIframe(video_id) {
            return getYoutubeIFrame(video_id);
        },
    },
};
</script>
