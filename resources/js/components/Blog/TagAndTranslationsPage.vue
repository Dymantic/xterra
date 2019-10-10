<template>
    <div class="max-w-4xl mx-auto" v-if="tag">
        <section class="flex justify-between items-center py-8">
            <h1 class="flex-1 text-5xl font-bold">Tag: {{ tag.tag_name }}</h1>
            <div class="flex justify-end items-center">

            </div>
        </section>
        <div class="my-12">
            <div v-for="translation in translations" :key="translation.id" class="mb-4">
                <router-link :to="`/articles/${translation.article_id}`">
                    <div class="flex items-center bg-white py-2">
                        <span class="px-4 uppercase font-bold text-gray-600">{{ translation.language }}</span>
                        <span class="w-120 text-truncate">{{ translation.title }}</span>
                        <translation-status :show-date="true" :translation="translation"></translation-status>
                        <span class="text-sm text-gray-600 pl-6">{{ translation.author_name }}</span>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import {notify} from "../Messaging/notify";
    import TranslationStatus from "./TranslationStatus";

    export default {
        components: {
            TranslationStatus,
        },

        data() {
            return {
                translations: [],
                ready: false,
            };
        },

        computed: {
            tag_id() {
                return this.$route.params.id;
            },

            tag() {
                return this.$store.getters['articles/tagById'](this.tag_id);
            }
        },

        mounted() {
            this.$store.dispatch('articles/fetchTranslationsForTag', this.tag_id)
                .then(translations => this.translations = translations)
                .catch(notify.error);
        },
    }
</script>
