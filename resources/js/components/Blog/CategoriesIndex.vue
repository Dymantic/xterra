<template>
    <div>
        <section class="max-w-4xl mx-auto flex justify-between items-center py-8">
            <h1 class="flex-1 text-5xl font-bold">Categories</h1>
            <div class="flex justify-end items-center">
                <router-link class="btn btn-dark" to="/categories/create">Add Category</router-link>
            </div>
        </section>
        <div class="max-w-2xl mx-auto bg-white shadow-lg p-8">
            <div v-for="category in categories" :key="category.id" class="flex justify-between items-center my-4">
                <router-link class="text-lg font-bold capitalize hover:underline" :to="`/categories/${category.id}`">{{ category.title.en }}</router-link>
                <p class="text-gray-600 ml-8">{{ category.articles_count}} articles</p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        computed: {
            categories() {
                return this.$store.state.articles.categories;
            }
        }
    }
</script>
