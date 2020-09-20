<template>
    <page>
        <page-header title="Content Cards">
            <router-link to="/content-cards/create" class="btn btn-dark"
                >Make New Card</router-link
            >
        </page-header>

        <div class="mb-12">
            <p>Create from an existing piece of content</p>
            <div class="mt-4">
                <event-selector
                    @event-selected="createFromEvent"
                    class="mr-6"
                ></event-selector>
                <article-selector
                    @article-selected="createFromArticle"
                    class="mx-6"
                ></article-selector>
                <promotion-selector
                    @promo-selected="createFromPromotion"
                    class="mx-6"
                ></promotion-selector>
            </div>
        </div>

        <div class="my-12">
            <language-selector v-model="lang"></language-selector>
        </div>

        <div class="flex flex-wrap items-start">
            <div
                v-for="card in cards"
                :key="card.id"
                class="relative shadow m-4 w-64"
            >
                <router-link :to="`/content-cards/${card.id}/show`">
                    <div class="w-64 h-42">
                        <img
                            :src="card.image.web"
                            alt=""
                            class="w-full h-full object-cover"
                        />
                    </div>
                </router-link>

                <p class="uppercase p-2 font-bold">{{ card.title[lang] }}</p>
                <p
                    class="m-2 bg-red-500 text-white absolute top-0 right-0 px-1 uppercase text-xs"
                >
                    {{ card.category[lang] }}
                </p>
            </div>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import LanguageSelector from "../LanguageSelector";
import EventSelector from "../Events/EventSelector";
import ArticleSelector from "../Blog/ArticleSelector";
import PromotionSelector from "../Promotions/PromotionSelector";

export default {
    components: {
        Page,
        PageHeader,
        LanguageSelector,
        EventSelector,
        ArticleSelector,
        PromotionSelector,
    },

    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        cards() {
            return this.$store.state.cards.all;
        },
    },

    created() {
        this.$store.dispatch("cards/fetchAll");
    },

    methods: {
        createFromEvent({ id }) {
            this.$store
                .dispatch("cards/createFromEvent", id)
                .catch(() => notify.error({ message: "Failed to make card" }));
        },

        createFromArticle({ id }) {
            this.$store
                .dispatch("cards/createFromArticle", id)
                .catch(() => notify.error({ message: "Failed to make card" }));
        },

        createFromPromotion({ id }) {
            this.$store
                .dispatch("cards/createFromPromotion", id)
                .catch(() => notify.error({ message: "Failed to make card" }));
        },
    },
};
</script>
