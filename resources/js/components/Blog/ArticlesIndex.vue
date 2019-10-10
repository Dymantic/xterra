<template>
    <div>
        <section class="max-w-4xl mx-auto flex justify-between items-center py-8">
            <h1 class="flex-1 text-5xl font-bold">Articles</h1>
            <div class="flex justify-end items-center">
                <create-new-article @article-created="articleCreated"
                                    @create-article-error="createArticleError"
                ></create-new-article>
            </div>
        </section>
        <div class="flex justify-between">
            <div class="w-80 px-4 pt-8">
                <p class="font-bold text-lg uppercase text-gray-600">Filters</p>
                <div class="my-6">
                    <p class="font-bold uppercase tracking-wide text-sm mb-2">Status</p>
                    <div>
                        <input type="checkbox"
                               v-model="filters.status.live"
                               id="live_articles">
                        <label class="form-label text-sm" for="live_articles">Live</label>
                    </div>
                    <div>
                        <input type="checkbox"
                               v-model="filters.status.scheduled"
                               id="scheduled_articles">
                        <label class="form-label text-sm" for="scheduled_articles">Scheduled</label>
                    </div>
                    <div>
                        <input type="checkbox"
                               v-model="filters.status.draft"
                               id="draft_articles">
                        <label class="form-label text-sm" for="draft_articles">Drafts</label>
                    </div>
                </div>
                <div class="my-8">
                    <p class="font-bold uppercase tracking-wide text-sm mb-2">Title</p>
                    <input type="text"
                           v-model="filters.title"
                           class="form-input">
                </div>
                <div class="my-8">
                    <p class="font-bold uppercase tracking-wide text-sm mb-2">Author</p>
                    <input type="text"
                           v-model="filters.author"
                           class="form-input">
                </div>
                <div class="my-8" v-if="has_category_filters">
                    <p class="font-bold uppercase tracking-wide text-sm mb-2">Categories</p>
                    <div v-for="category in categories"
                         :key="category.id">
                        <div>
                            <input v-model="filters.categories[category.id]"
                                   type="checkbox"
                                   :id="`category_${category.id}`">
                            <label class="form-label text-sm" :for="`category_${category.id}`">{{ category.title.en }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1">
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

            articleCreated(article) {
                console.log(article);
            },

            createArticleError() {
                notify.error({message: 'Unable to create the article'});
            }
        }
    }
</script>
