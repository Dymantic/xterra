<template>
    <span>
        <button @click="showModal = true"
                class="btn btn-dark">Select Article</button>
        <modal :show="showModal"
               @close="showModal = false">
            <div class="p-8 w-120 max-w-full">
                <p class="text-lg font-bold mb-4">Find and select an article for this slide</p>
                <p class="text-gray-600 text-sm mb-2">Search articles by title (English or Chinese)</p>
                <div>
                    <input @keyup="doSearch"
                           type="text"
                           v-model="query"
                           class="form-input">
                </div>
                <div class="h-80 overflow-auto pt-4">
                    <div v-for="result in results"
                         @click="selectArticle(result.id)"
                         class="border-b text-sm mb-2 pb-2 hover:bg-gray-200 cursor-pointer">
                        <p v-for="translation in result.translations"
                           :key="translation.id">
                            {{ translation.title }}
                        </p>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button @click="showModal = false"
                            class="bg-white text-gray-600 font-bold hover:text-blue-500">Cancel</button>
                </div>
            </div>

        </modal>
    </span>
</template>

<script type="text/babel">
    import Modal from "@dymantic/modal";
    import debounce from "lodash.debounce";
    import {notify} from "../Messaging/notify";

    export default {
        components: {
            Modal,
        },

        data() {
            return {
                showModal: false,
                results: [],
                query: '',
            };
        },

        methods: {
            doSearch: debounce(function () {
                this.$store.dispatch('articles/searchArticles', this.query)
                    .then(articles => this.results = articles)
                    .catch(notify.error);
            }, 200),

            selectArticle(id) {
                this.$emit('article-selected', id);
                this.results = [];
                this.query = '';
                this.showModal = false;
            }
        }
    }
</script>