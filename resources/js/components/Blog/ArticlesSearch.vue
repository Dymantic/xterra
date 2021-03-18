<template>
    <page>
        <page-header title="Search Articles">
            <router-link to="/articles">&larr; Back to articles</router-link>
        </page-header>

        <div class="max-w-4xl mx-auto my-12">
            <input-field @input="doSearch" label="" v-model="query" placeholder="Search by title or author"></input-field>
        </div>
        <div>
            <p v-show="waiting">Searching...</p>
            <p v-show="!waiting && query.length > 0">Found {{ matches.length }} results for "{{ query}}"</p>
        </div>
        <router-link v-for="article in matches" :key="article.id" :to="`/articles/${article.id}`">
            <article-index-card :article="article">
            </article-index-card>
        </router-link>
    </page>
</template>

<script type="text/babel">
    import InputField from "../Forms/InputField";
    import ArticleIndexCard from "./ArticleIndexCard";
    import debounce from "lodash.debounce";
    import {notify} from "../Messaging/notify";
    export default {
        components: {InputField, ArticleIndexCard},

        data() {
            return {
                query: '',
                matches: [],
                waiting: false,
            };
        },

        methods: {
            doSearch: debounce(function() {
                this.waiting = true;
                this.$store.dispatch("articles/searchArticles", this.query)
                .then(matches => this.matches = matches)
                .catch(() => notify.error("Oops, an error occurred"))
                .then(() => this.waiting = false);
            }, 300)
        }

    }
</script>
