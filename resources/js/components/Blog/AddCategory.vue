<template>
    <div>
        <section class="max-w-4xl mx-auto flex justify-between items-center py-8">
            <h1 class="flex-1 text-5xl font-bold">Add a Category</h1>
            <div class="flex justify-end items-center">
                <router-link class="btn btn-link" to="/categories">Back to Categories</router-link>
            </div>
        </section>
        <category-form :category-id="null"></category-form>
    </div>
</template>

<script type="text/babel">
    import CategoryForm from "./CategoryForm";

    export default {
        components: {
            CategoryForm,
        }
    }
</script>