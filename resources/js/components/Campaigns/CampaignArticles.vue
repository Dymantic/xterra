<template>
    <div>
        <div class="flex justify-between mb-12">
            <p class="font-bold text-lg">Campaign Articles</p>
            <div class="flex justify-end">
                <article-selector
                    @article-selected="saveArticle"
                ></article-selector>
            </div>
        </div>

        <div class="my-12">
            <div>
                <div
                    v-for="article in campaign.articles"
                    :key="article.id"
                    class="my-4 shadow relative"
                >
                    <div class="flex items-stretch">
                        <div class="w-40 h-full">
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
                            <div class="flex justify-end mt-4">
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
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import ArticleSelector from "../Blog/ArticleSelector";
import { notify } from "../Messaging/notify";

export default {
    components: {
        ArticleSelector,
    },

    computed: {
        campaign() {
            return this.$store.getters["campaigns/byId"](
                this.$route.params.campaign
            );
        },
    },

    methods: {
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
