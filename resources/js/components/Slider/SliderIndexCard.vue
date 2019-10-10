<template>
    <div>
        <div class="bg-white shadow-lg w-full my-12 p-4">
            <p class="mb-2 text-sm text-gray-600">Position: {{ position }}</p>
            <div v-if="!slide"
                 class="h-32 flex justify-center items-center">
                <p class="text-xl text-gray-600 font-bold">No article set for slide</p>
            </div>
            <div v-if="slide"
                 class="flex">
                <div class="w-48 h-32">
                    <img :src="article_thumb"
                         class="object-fill w-full h-full">
                </div>
                <div class="flex-1 pl-8">
                    <div v-for="translation in translations"
                         class="flex">
                        <p class="pr-4 text-lg">{{ translation.title }}</p>
                        <translation-status :translation="translation"></translation-status>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-end">
                <button v-if="slide"
                        @click="removeArticle"
                        class="bg-white text-gray-600 hover:text-blue-500 mr-4 font-bold">Clear
                </button>
                <router-link v-if="slide"
                             :to="`/articles/${slide.article.id}`"
                             class="bg-white text-gray-600 hover:text-blue-500 mx-4 font-bold">View Article
                </router-link>
                <article-search @article-selected="setArticle"></article-search>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import ArticleSearch from "./ArticleSearch";
    import {notify} from "../Messaging/notify";
    import TranslationStatus from "../Blog/TranslationStatus";

    export default {

        components: {
            ArticleSearch,
            TranslationStatus,
        },

        props: ['slide', 'position'],

        computed: {
            article_thumb() {
                return this.slide.article.title_image.thumb || 'data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==';
            },

            translations() {
                if (!this.slide.article) {
                    return []
                }

                return this.slide.article.translations;
            }
        },

        methods: {
            setArticle(id) {
                this.$store.dispatch('slider/setArticleForSlide', {position: this.position, article_id: id})
                    .then(notify.success)
                    .catch(notify.error);
            },

            removeArticle() {
                if (!this.slide) {
                    return;
                }
                this.$store.dispatch('slider/clearSlide', this.position)
                    .then(notify.success)
                    .catch(notify.error);
            }
        }
    }
</script>