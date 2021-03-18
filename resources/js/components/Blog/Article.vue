<template>
    <div v-if="article" :key="$route.fullPath">
        <section class="max-w-4xl mx-auto flex justify-between items-center py-8">
            <h1 class="flex-1 text-5xl font-bold">Article #{{ article.id }}</h1>
            <div class="flex justify-end items-center">
                <delete-article-button :article-id="article.id"></delete-article-button>
            </div>
        </section>
        <div class="max-w-4xl mx-auto p-8 bg-white mb-20">
            <div class="max-w-4xl mx-auto flex justify-between">
                <div class="w-1/2 mr-4 bg-white p-4">
                    <p class="uppercase tracking-wide text-gray-800 mb-8">Cover Image</p>
                    <image-upload :upload-url="image_upload_url"
                                  :initial-src="title_image"
                                  :preview-width="512"
                                  :aspect-x="4"
                                  :aspect-y="3"
                                  :max-size="15"
                                  @invalid-file-selected="invalidFileError"
                                  @image-upload-failed="uploadError"
                                  @image-uploaded="uploadedImage"
                                  class="w-80"
                                  v-if="article"
                                  :key="article.id"
                    ></image-upload>
                    <p class="text-sm text-gray-600 w-80 mt-4">Click above to upload the cover image for the article. The image must be at least 1800px wide, under 15MB and either a PNG or JPG</p>

                </div>
                <div class="w-1/2 p-4 bg-white ml-4">
                    <div class="flex justify-between items-center mb-8">
                        <p class="uppercase tracking-wide text-gray-800">Categories</p>
                        <categories-form :article-id="article.id"
                                         :initial-categories="current_category_ids"
                        ></categories-form>
                    </div>

                    <div>
                        <p v-for="category in article.categories"
                           :key="category.id">{{ category.title.en }}</p>
                    </div>
                    <p class="text-gray-600"
                       v-if="!article.categories.length">This article is not associated with any categories.</p>
                </div>

            </div>
            <div class="flex justify-between items-center border-gray-300 border-b mt-12 mb-8 mx-4">
                <p class="uppercase tracking-wide text-gray-800">Translations</p>
                <add-translation v-if="missing_translation"
                                 :article-id="article.id"
                                 :language="missing_translation"></add-translation>
            </div>

            <div class="px-8 mx-4 mb-8 bg-white max-w-4xl mx-auto"
                 v-for="translation in article.translations">
                <p class="text-lg font-bold">
                    <router-link :to="`/translations/${translation.id}/edit`">{{ translation.title }}</router-link>
                </p>
                <div class="flex items-center">
                    <translation-status :translation="translation"></translation-status>
                    <p class="mx-4 text-sm text-gray-600">{{ translation.publish_date }}</p>
                    <p class="text-sm text-gray-600">{{ translation.author_name }}</p>
                </div>

                <p class="my-4">{{ withDefault(translation.intro, "This translation does not have an intro yet") }}</p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import {notify} from "../Messaging/notify";
    import {ImageUpload} from "@dymantic/imagineer";
    import CategoriesForm from "./CategoriesForm";
    import TranslationStatus from "./TranslationStatus";
    import AddTranslation from "./AddTranslation";
    import DeleteArticleButton from "./DeleteArticleButton";

    export default {
        components: {
            ImageUpload,
            CategoriesForm,
            TranslationStatus,
            AddTranslation,
            DeleteArticleButton,
        },

        data() {
            return {
                article: null,
            };
        },

        mounted() {
            this.$store.dispatch("articles/fetchById", this.$route.params.id)
            .then(article => this.article = article)
            .catch(() => notify.error("Failed to find article"))
        },

        computed: {


            title_image() {
                if (!this.article) {
                    return "";
                }

                return this.article.title_image.thumb;
            },

            image_upload_url() {
                return `/admin/articles/${this.article.id}/title-image`;
            },

            current_category_ids() {
                return this.article.categories.map(cat => cat.id);
            },

            missing_translation() {
                const langs = [{code: 'en', name: 'English'}, {code: 'zh', name: 'Chinese'}];
                const missing = langs.filter(l => !this.article.translations.map(t => t.language).includes(l.code));
                if (missing.length === 1) {
                    return missing[0];
                }
            }
        },

        methods: {

            getArticle() {
                this.$store.dispatch('articles/fetchArticle', this.article.id)
                    .then(article => this.article = article)
                    .catch(notify.error);
            },

            invalidFileError(message) {
                notify.error({message});
            },

            uploadError(message) {
                notify.error({message});
            },

            uploadedImage(message) {
                notify.success({message: 'Your image has been saved.'});
            },

            withDefault(property, alt) {
                if (!property) {
                    return alt;
                }
                return property;
            }
        }
    }
</script>

