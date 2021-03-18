<template>
    <div>
        <section class="max-w-4xl mx-auto flex justify-between items-center py-8">
            <h1 class="flex-1 text-5xl font-bold">Articles</h1>
            <div class="flex justify-end items-center">
                <router-link to="/search-articles" class="mx-4 hover:text-blue-600 font-semibold">Search</router-link>
                <create-new-article @create-article-error="createArticleError"
                ></create-new-article>
            </div>
        </section>
        <div class="max-w-4xl mx-auto pb-20">
            <div class="">
                <div class="flex justify-end px-6">
                    <button class="mx-4 hover:text-blue-600" :class="{'opacity-50': !hasPreviousPage}" :disabled="!hasPreviousPage" @click="prevPage">&lt;&lt;</button>
                    <p class="">Page {{ $store.state.articles.page}} of {{ $store.state.articles.total_pages }}</p>
                    <button class="mx-4 hover:text-blue-600" :class="{'opacity-50': !hasNextPage}" :disabled="!hasNextPage" @click="nextPage">&gt;&gt;</button>
                </div>
                <router-link v-for="article in articles" :key="article.id" :to="`/articles/${article.id}`">
                    <article-index-card :article="article" :filters="filters">
                    </article-index-card>
                </router-link>
            </div>

        </div>
    </div>
</template>

<script type="text/babel">
    import ArticleIndexCard from "./ArticleIndexCard";
    import {notify} from "../Messaging/notify";
    import CreateNewArticle from "./CreateNewArticle";

    export default {

        components: {
            ArticleIndexCard,
            CreateNewArticle
        },

        data() {
            return {
                filters: {
                    status: {
                        live: true,
                        scheduled: true,
                        draft: true,
                    },
                    title: '',
                    author: '',
                    categories: {}
                }
            };
        },

        computed: {
            articles() {
                return this.$store.state.articles.articles.filter(this.categoryFilter);
            },

            hasNextPage() {
                return this.$store.state.articles.has_next_page;
            },

            hasPreviousPage() {
                return this.$store.state.articles.page > 1;
            },

            categories() {
                return this.$store.state.articles.categories;
            },

            has_category_filters() {
              return Object.keys(this.filters.categories).length > 1;
            },

            categoryFilter() {
                return (article) => {
                    if(article.categories.length === 0) {
                        return true;
                    }

                    const filters = Object.keys(this.filters.categories)
                                          .filter(k => this.filters.categories[k])
                                          .map(k => parseInt(k));
                    const article_cats = article.categories.map(cat => cat.id);

                    return filters.some(x => article_cats.includes(x));
                }
            }
        },

        mounted() {
            if (this.categories.length > 0 && (!this.has_category_filters)) {
                this.setupFilterCategories();
            }
        },

        watch: {
            categories(newCategories) {
                if((!this.has_category_filters) && (newCategories.length > 0)) {
                    this.setupFilterCategories();
                }
            }
        },

        methods: {

            nextPage() {
                this.$store.commit("articles/turnPage");
                this.$store.dispatch("articles/fetchAll");
            },

            prevPage() {
                this.$store.commit("articles/turnBackPage");
                this.$store.dispatch("articles/fetchAll");
            },

            setupFilterCategories() {
                this.filters.categories = this.categories.reduce((acc, cat) => {
                    acc[cat.id] = true;
                    return acc;
                }, {});
            },

            setCategoryFilter(category_id, ev) {
                if (ev.target.checked) {
                    return this.filters.categories.push(category_id);
                }

                this.filters.categories = this.filters.categories
                                              .filter(cat => cat.id !== category_id);
            },

            createArticleError() {
                notify.error({message: 'Unable to create the article'});
            }
        }
    }
</script>
