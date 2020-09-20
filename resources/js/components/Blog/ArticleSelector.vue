<template>
    <span>
        <button @click="showModal = true" class="btn btn-dark">
            Select Article
        </button>
        <modal :show="showModal" @close="showModal = false">
            <div class="max-w-xl w-screen p-6">
                <p class="font-bold text-lg mb-6">Select an Article</p>
                <div>
                    <input-field
                        label="Search"
                        placeholder="Search by English or Chinese title"
                        v-model="search"
                    ></input-field>
                </div>
                <p class="my-4 text-gray-600" v-show="searching">
                    Searching...
                </p>
                <p
                    v-if="!searching && search.length > 2 && !options.length"
                    class="text-gray-600 my-4"
                >
                    There are no results for "{{ search }}"
                </p>
                <div class="h-80 pt-6 overflow-auto">
                    <div
                        v-for="article in options"
                        :key="article.id"
                        class="border-b border-gray-300 flex justify-between items-center p-2 my-4"
                    >
                        <div class="">
                            <p v-for="translation in article.translations">
                                {{ translation.title }}
                            </p>
                        </div>
                        <button
                            class="font-bold text-sm hover:text-blue-600"
                            @click="selectArticle(article)"
                        >
                            Select
                        </button>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="button" class="btn" @click="close">
                        Cancel
                    </button>
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
import Modal from "@dymantic/modal";
import debounce from "lodash.debounce";
import InputField from "../Forms/InputField";
import { get } from "../../apis/http";
import { notify } from "../Messaging/notify";

export default {
    components: {
        InputField,
    },

    data() {
        return {
            showModal: false,
            search: "",
            options: [],
            searching: false,
        };
    },

    computed: {},

    watch: {
        search() {
            this.fetchArticles();
        },
    },

    created() {
        this.$store.dispatch("promotions/fetchAll");
    },

    methods: {
        fetchArticles: debounce(function () {
            if (this.search.length < 3) {
                this.options = [];
                return;
            }
            this.searching = true;
            get(`/admin/search/articles?query=${this.search}`)
                .then((articles) => (this.options = articles))
                .catch(() =>
                    notify.error({ message: "Error searching articles" })
                )
                .then(() => (this.searching = false));
        }, 250),

        selectArticle(article) {
            this.$emit("article-selected", article);
            this.close();
        },

        close() {
            this.search = "";
            this.showModal = false;
        },
    },
};
</script>
