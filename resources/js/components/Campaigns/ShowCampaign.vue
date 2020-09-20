<template>
    <page v-if="campaign">
        <page-header :title="campaign.title.en">
            <router-link
                :to="`/campaigns/${campaign.id}/edit`"
                class="btn btn-dark"
                >Edit Info</router-link
            >
        </page-header>
        <div>
            <language-selector v-model="lang"></language-selector>
        </div>

        <div>
            <div class="flex justify-between">
                <div>
                    <p class="text-3xl">{{ campaign.title[lang] }}</p>
                    <p class="my-4">{{ campaign.intro[lang] }}</p>
                    <p class="my-4 text-sm text-gray-600">
                        {{ campaign.description[lang] }}
                    </p>
                </div>
                <div class="ml-8 w-80">
                    <image-upload
                        :initial-src="campaign.title_image.web"
                        :upload-path="`/admin/campaigns/${campaign.id}/title-image`"
                        :delete-path="`/admin/campaigns/${campaign.id}/title-image`"
                        width="64"
                        height="42"
                        @uploaded="$store.dispatch('campaigns/refresh')"
                        @invalid-file="handleInvalid"
                        @upload-failed="handleFailure"
                    ></image-upload>
                </div>
            </div>
        </div>
        <div class="my-12">
            <div class="flex justify-between mb-6 border-b border-gray-400">
                <p class="uppercase text-lg text-red-700 mb-4">
                    Campaign Event
                </p>
                <event-selector @event-selected="setEvent"></event-selector>
            </div>
            <div v-if="!campaign.event">
                <p class="my-4 text-gray-600">
                    No event has been assigned to this campaign
                </p>
            </div>
            <div v-else>
                <p class="text-lg font-bold">{{ campaign.event.name[lang] }}</p>
                <p class="text-gray-600 mt-2">
                    <span>{{ campaign.event.location[lang] }}</span>
                    <span
                        class="pl-4 ml-4 border-l border-gray-400"
                        v-if="campaign.event.dates"
                        >{{ campaign.event.dates }}</span
                    >
                </p>
            </div>
        </div>

        <div class="my-12">
            <div class="flex justify-between mb-6 border-b border-gray-400">
                <p class="uppercase text-lg text-red-700 mb-4">
                    Campaign Promotion
                </p>
                <promotion-selector
                    @promo-selected="setPromotion"
                ></promotion-selector>
            </div>
            <div v-if="!campaign.promotion">
                <p class="my-4 text-gray-600">
                    No promotion has been assigned to this campaign
                </p>
            </div>
            <div v-else>
                <div class="flex items-center">
                    <div class="h-12 w-16 mr-4">
                        <img
                            :src="campaign.promotion.image.thumb"
                            class="w-full h-full object-cover"
                            alt=""
                        />
                    </div>
                    <p class="font-bold mb-1">
                        {{ campaign.promotion.title[lang] }}
                    </p>
                </div>
            </div>
        </div>

        <div class="my-12">
            <div class="flex justify-between mb-6 border-b border-gray-400">
                <p class="uppercase text-lg text-red-700 mb-4">
                    Campaign Articles
                </p>
                <article-selector
                    @article-selected="saveArticle"
                ></article-selector>
            </div>
            <div>
                <div
                    v-for="article in campaign.articles"
                    :key="article.id"
                    class="my-4 shadow relative"
                >
                    <div class="flex">
                        <div class="w-32 h-24">
                            <img
                                :src="article.title_image.thumb"
                                class="w-full h-full object-cover"
                                alt=""
                            />
                        </div>
                        <div class="px-4 py-2">
                            <p
                                class="mb-1"
                                v-for="translation in article.translations"
                            >
                                {{ translation.title }}
                            </p>
                        </div>
                    </div>
                    <div class="m-3 absolute bottom-0 right-0">
                        <button
                            class="font-bold text-red-500 hover:text-red-700"
                            @click="removeArticle(article)"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-12">
            <div
                class="flex justify-between items-center mb-6 border-b border-gray-400"
            >
                <p class="uppercase text-lg text-red-700 mb-4">Content</p>
                <router-link
                    class="btn btn-dark"
                    :to="`/campaigns/${campaign.id}/edit-content/${this.lang}`"
                    >Edit content</router-link
                >
            </div>
            <div
                class="max-w-3xl mx-auto"
                v-html="campaign.narrative_html[lang]"
            ></div>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import LanguageSelector from "../LanguageSelector";
import ImageUpload from "../ImageUpload";
import EventSelector from "../Events/EventSelector";
import PromotionSelector from "../Promotions/PromotionSelector";
import ArticleSelector from "../Blog/ArticleSelector";
import { notify } from "../Messaging/notify";
export default {
    components: {
        Page,
        PageHeader,
        LanguageSelector,
        ImageUpload,
        EventSelector,
        PromotionSelector,
        ArticleSelector,
    },

    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        campaign() {
            return this.$store.getters["campaigns/byId"](
                this.$route.params.campaign
            );
        },
    },

    created() {
        this.$store.dispatch("campaigns/fetchAll");
    },

    methods: {
        handleInvalid(message) {
            notify.warn({ message });
        },

        handleFailure() {
            notify.error({ message: "Unable to set title image" });
        },

        setEvent({ id }) {
            this.$store
                .dispatch("campaigns/setEvent", {
                    event_id: id,
                    campaign_id: this.campaign.id,
                })
                .then(() => notify.success({ message: "Event updated." }))
                .catch(() => notify.error({ message: "Failed to set event" }));
        },

        setPromotion({ id }) {
            this.$store
                .dispatch("campaigns/setPromotion", {
                    campaign_id: this.campaign.id,
                    promotion_id: id,
                })
                .then(() => notify.success({ message: "Promotion updated." }))
                .catch(() =>
                    notify.error({ message: "Failed to set promotion" })
                );
        },

        saveArticle({ id }) {
            this.$store
                .dispatch("campaigns/assignArticle", {
                    campaign_id: this.campaign.id,
                    article_id: id,
                })
                .then(() => notify.success({ message: "Article added." }))
                .catch(() =>
                    notify.error({ message: "Failed to add article" })
                );
        },

        removeArticle({ id }) {
            this.$store
                .dispatch("campaigns/removeArticle", {
                    campaign_id: this.campaign.id,
                    article_id: id,
                })
                .then(() => notify.success({ message: "Article removed." }))
                .catch(() =>
                    notify.error({ message: "Failed to remove article" })
                );
        },
    },
};
</script>
