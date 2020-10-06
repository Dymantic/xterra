<template>
    <page v-if="ready">
        <page-header title="Home Page"></page-header>

        <div class="my-12">
            <LanguageSelector v-model="lang"></LanguageSelector>
        </div>

        <div class="my-12">
            <p
                class="uppercase text-lg text-red-700 mb-4 border-b border-gray-300"
            >
                Banner Image
            </p>

            <div class="my-8 shadow rounded p-6">
                <p class="my-4 text-gray-600">
                    This image is used as the main banner. It should be at least
                    2000px wide, and 1125px high. If the aspect ratio differs
                    from 16:9 it will be cropped from the center.
                </p>
                <div class="w-120 mx-auto">
                    <image-upload
                        :initial-src="banner.full"
                        :upload-path="`/admin/home-page/banner-image`"
                        :delete-path="`/admin/home-page/banner-image`"
                        width="120"
                        height="64"
                        @uploaded="$store.dispatch('homepage/fetchHomePage')"
                    ></image-upload>
                </div>
            </div>
        </div>

        <div class="my-12">
            <div class="flex justify-between mb-6 border-b border-gray-400">
                <p class="uppercase text-lg text-red-700 mb-4">
                    Featured Event
                </p>
                <event-selector @event-selected="setEvent"></event-selector>
            </div>
            <div v-if="!event">
                <p class="my-4 text-gray-600">
                    No event has been featured on the home page
                </p>
            </div>
            <div v-else>
                <p class="text-lg font-bold">{{ event.name[lang] }}</p>
                <p class="text-gray-600 mt-2">
                    <span>{{ event.location[lang] }}</span>
                    <span
                        class="pl-4 ml-4 border-l border-gray-400"
                        v-if="event.dates"
                        >{{ event.dates }}</span
                    >
                </p>
            </div>
        </div>

        <div class="my-12">
            <div class="flex justify-between mb-6 border-b border-gray-400">
                <p class="uppercase text-lg text-red-700 mb-4">
                    Featured Promotion
                </p>
                <promotion-selector
                    @promo-selected="setPromotion"
                ></promotion-selector>
            </div>
            <div v-if="!promotion">
                <p class="my-4 text-gray-600">
                    No promotion has been featured on the home page
                </p>
            </div>
            <div v-else>
                <div class="flex items-center">
                    <div class="h-12 w-16 mr-4">
                        <img
                            :src="promotion.image.thumb"
                            class="w-full h-full object-cover"
                            alt=""
                        />
                    </div>
                    <p class="font-bold mb-1">
                        {{ promotion.title[lang] }}
                    </p>
                </div>
            </div>
        </div>

        <div class="my-12">
            <div class="flex justify-between mb-6 border-b border-gray-400">
                <p class="uppercase text-lg text-red-700 mb-4">
                    Featured Campaign
                </p>
                <campaign-selector
                    @campaign-selected="setCampaign"
                ></campaign-selector>
            </div>
            <div v-if="!campaign">
                <p class="my-4 text-gray-600">
                    No campaign has been featured on the home page
                </p>
            </div>
            <div v-else>
                <div class="flex items-center">
                    <div class="h-12 w-16 mr-4">
                        <img
                            :src="campaign.title_image.thumb"
                            class="w-full h-full object-cover"
                            alt=""
                        />
                    </div>
                    <p class="font-bold mb-1">
                        {{ campaign.title[lang] }}
                    </p>
                </div>
            </div>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import ImageUpload from "../ImageUpload";
import EventSelector from "../Events/EventSelector";
import PromotionSelector from "../Promotions/PromotionSelector";
import CampaignSelector from "../Campaigns/CampaignSelector";
import LanguageSelector from "../LanguageSelector";
import { notify } from "../Messaging/notify";
export default {
    components: {
        Page,
        PageHeader,
        ImageUpload,
        EventSelector,
        PromotionSelector,
        CampaignSelector,
        LanguageSelector,
    },

    data() {
        return {
            ready: false,
            lang: "en",
        };
    },

    computed: {
        banner() {
            return this.$store.state.homepage.banner_image;
        },

        event() {
            return this.$store.state.homepage.event;
        },

        campaign() {
            return this.$store.state.homepage.campaign;
        },

        promotion() {
            return this.$store.state.homepage.promotion;
        },
    },

    created() {
        this.$store
            .dispatch("homepage/fetchHomePage")
            .then(() => (this.ready = true))
            .catch(() =>
                notify.error({ message: "Error fetching homepage info" })
            );
    },

    methods: {
        setEvent({ id }) {
            this.$store
                .dispatch("homepage/attachEvent", id)
                .catch(() =>
                    notify.error({ message: "Failed to attach event" })
                );
        },

        setPromotion({ id }) {
            this.$store
                .dispatch("homepage/attachPromotion", id)
                .catch(() =>
                    notify.error({ message: "Failed to attach event" })
                );
        },

        setCampaign({ id }) {
            this.$store
                .dispatch("homepage/attachCampaign", id)
                .catch(() =>
                    notify.error({ message: "Failed to attach event" })
                );
        },
    },
};
</script>
