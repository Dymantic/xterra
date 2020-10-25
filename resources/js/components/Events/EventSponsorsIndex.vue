<template>
    <div v-if="event">
        <div class="flex justify-between items-center mb-12">
            <p class="text-lg font-bold">Event Sponsors</p>
            <div class="flex justify-end">
                <router-link
                    class="btn mr-4"
                    :to="`/events/${event.id}/edit/sponsors/order`"
                    >Set Order</router-link
                >
                <router-link
                    class="btn btn-dark"
                    :to="`/events/${event.id}/edit/sponsors/create`"
                    >Add Sponsor</router-link
                >
            </div>
        </div>

        <div class="my-12">
            <language-selector v-model="lang"></language-selector>
        </div>

        <div class="my-12">
            <div
                v-for="sponsor in event.sponsors"
                :key="sponsor.id"
                class="p-6 shadow mb-8"
            >
                <div class="flex justify-between mb-3">
                    <p class="font-bold mb-2">{{ sponsor.name[lang] }}</p>
                    <router-link
                        :to="`/events/${$route.params.id}/edit/sponsors/${sponsor.id}/edit`"
                        class="btn"
                        >Edit</router-link
                    >
                </div>
                <div class="flex justify-between">
                    <div class="flex-1 pr-8">
                        <div class="flex items-center mb-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                class="stroke-current h-4 text-gray-600 mr-3"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"
                                />
                            </svg>
                            <a
                                target="_blank"
                                :href="sponsor.link"
                                class="text-gray-600 hover:text-blue-500"
                            >
                                {{ sponsor.link }}
                            </a>
                        </div>
                        <p class="text-xs">{{ sponsor.description[lang] }}</p>
                    </div>
                    <div class="w-40">
                        <image-upload
                            :initial-src="sponsor.logo.thumb"
                            :upload-path="`/admin/event-sponsors/${sponsor.id}/image`"
                            :delete-path="`/admin/event-sponsors/${sponsor.id}/image`"
                            width="40"
                            height="40"
                            :contain="true"
                            @uploaded="$store.dispatch('events/refreshEvents')"
                            @upload-failed="handleFail"
                            @clear-failed="handleFail"
                            @invalid-file="handleInvalid"
                        ></image-upload>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import ImageUpload from "../ImageUpload";
import LanguageSelector from "../LanguageSelector";
import { notify } from "../Messaging/notify";
export default {
    components: { LanguageSelector, ImageUpload },

    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        event() {
            return this.$store.state.events.current_page_event;
        },
    },

    methods: {
        handleFail() {
            notify.error({ message: "An error occurred" });
        },

        handleInvalid(message) {
            notify.warn({ message });
        },
    },
};
</script>
