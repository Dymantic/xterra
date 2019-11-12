<template>
    <div v-if="category">
        <section class="max-w-4xl mx-auto flex justify-between items-center py-8">
            <h1 class="flex-1 text-5xl font-bold">Edit Category</h1>
            <div class="flex justify-end items-center">
                <router-link class="btn btn-link" :to="`/categories/${category.id}`">Back to Category</router-link>
            </div>
        </section>
        <category-form v-if="category" :category-id="category.id" :initial-data="category"></category-form>
    </div>
</template>


<script type="text/babel">
    import CategoryForm from "./CategoryForm";
    import {notify} from "../Messaging/notify";

    export default {
        components: {
            CategoryForm,

        },

        data() {
            return {
                category: null,
            };
        },

        watch: {
            '$route': function () {
                this.$router.go();
            }
        },


        mounted() {
            this.category = this.$store.getters['articles/categoryById'](this.$route.params.id);
            if (!this.category) {
                this.$store.dispatch('articles/fetchCategories')
                    .then(() => this.category = this.$store.getters['articles/categoryById'](this.$route.params.id))
                    .catch(notify.error);
            }
        },
    }
</script>
