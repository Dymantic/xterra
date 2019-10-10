<template>
    <div>
        <section class="max-w-4xl mx-auto flex justify-between items-center py-8">
            <h1 class="flex-1 text-5xl font-bold">Edit Category</h1>
            <div class="flex justify-end items-center">
                <router-link class="btn btn-link" :to="`/categories/${category_id}`">Back to Category</router-link>
            </div>
        </section>
        <category-form v-if="category" :category-id="category_id" :initial-data="category"></category-form>
    </div>
</template>

<script type="text/babel">
    import CategoryForm from "./CategoryForm";

    export default {
        components: {
            CategoryForm,
        },

        computed: {
            category_id() {
                return this.$route.params.id;
            },

            category() {
                return this.$store.getters['articles/categoryById'](this.category_id);
            }
        }
    }
</script>