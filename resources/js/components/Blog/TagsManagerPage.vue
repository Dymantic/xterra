<template>
    <div class="max-w-4xl mx-auto">
        <section class="flex justify-between items-center py-8">
            <h1 class="flex-1 text-5xl font-bold">Manage Tags</h1>
            <div class="flex justify-end items-center">
                <router-link class="btn btn-dark" to="/tags/prune">Prune Tags</router-link>
            </div>
        </section>
        <div class="columns-3 my-20">
            <div v-for="tag in tags" :key="tag.id" class="flex items-center">
                <router-link :to="`/tags/${tag.id}`" class="uppercase hover:text-blue-500 font-bold mr-4">{{ tag.tag_name }}</router-link>
                <span class="text-sm text-gray-600">{{ tag.translations_count }}</span>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        computed: {
            tags() {
                return this.$store.getters['articles/tagsByName'];
            }
        }
    }
</script>
