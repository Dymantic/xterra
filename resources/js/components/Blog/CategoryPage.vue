<template>
    <div v-if="category">
        <section class="max-w-4xl mx-auto flex justify-between items-center py-8">
            <h1 class="flex-1 text-5xl font-bold">{{ category.title.en }}</h1>
            <div class="flex justify-end items-center">
                <delete-category :category-id="category_id" class="mr-4"></delete-category>
                <router-link class="btn btn-dark" :to="`/categories/${category_id}/edit`">Edit</router-link>
            </div>
        </section>
        <div class="max-w-4xl mx-auto bg-white shadow-lg p-8 flex justify-between">
            <div class="w-1/2 mr-4">
                <p class="mb-4 uppercase font-bold">{{ category.title.en }}</p>
                <p class="text-sm">{{ category.description.en }}</p>
            </div>
            <div class="w-1/2 ml-4">
                <p class="mb-4 uppercase font-bold">{{ category.title.zh }}</p>
                <p class="text-sm">{{ category.description.zh }}</p>
            </div>
        </div>

        <div class="my-20 max-w-4xl mx-auto">
            <p class="text-xl font-bold">Recent Articles</p>
            <p v-if="articles.length === 0">There are currently no articles associated with this category.</p>
            <article-index-card v-for="article in articles" :key="article.id" :article="article" :filters="filters"></article-index-card>
        </div>
    </div>
</template>

<script type="text/babel">
    import ArticleIndexCard from "./ArticleIndexCard";
    import DeleteCategory from "./DeleteCategory";

    export default {

        components: {
            ArticleIndexCard,
            DeleteCategory,
        },

        data() {
            return {
                filters: {
                    title: '',
                    author: '',
                    status: {
                        live: true,
                        draft: true,
                        scheduled: true,
                    }
                }
            };
        },

        computed: {
            category_id() {
                return this.$route.params.id;
            },

            category() {
                return this.$store.getters['articles/categoryById'](this.category_id);
            },

            articles() {
                return this.$store.getters['articles/articlesByCategoryId'](this.category_id);
            }
        }
    }
</script>
