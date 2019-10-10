<template>
    <span v-if="ready">
        <button @click="showForm = true"
                class="btn-sm btn-link">Edit categories</button>
        <modal :show="showForm"
               @close="showForm = false">
            <div class="p-8">
                <p class="uppercase text-gray-600 tracking-wide">Select Categories</p>
                <div v-if="formCategories !== {}"
                     class="mt-8">
                    <div v-for="category in categories"
                         :key="category.id"
                         class="mb-2">
                    <input type="checkbox"
                           :id="`category_${category.id}`"
                           v-model="formCategories[category.id]"
                           class="mr-4"
                           :disabled="waiting">
                    <label :for="`category_${category.id}`">{{ category.title.en }}</label>
                </div>
                <div class="flex justify-end mt-8">
                    <button @click="showForm = false"
                            :disabled="waiting">Cancel</button>
                    <button @click="submit"
                            :disabled="waiting"
                            class="btn btn-dark ml-4">Update</button>
                </div>
                </div>

            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    import Modal from "@dymantic/modal";
    import {notify} from "../Messaging/notify";

    export default {
        components: {
            Modal,
        },

        props: ['initial-categories', 'article-id'],

        data() {
            return {
                ready: false,
                waiting: false,
                showForm: false,
                formCategories: {}
            };
        },

        mounted() {
            if ((!this.ready) && (this.categories.length > 0)) {
                this.setupFormCategories();
            }
        },

        watch: {
            categories(newCategories) {
                if((!this.ready) && (newCategories.length > 0)) {
                    this.setupFormCategories();
                }
            }
        },

        computed: {
            categories() {
                return this.$store.state.articles.categories;
            },

            selected_categories() {
                return Object.keys(this.formCategories).filter(key => this.formCategories[key]);
            }
        },

        methods: {
            setupFormCategories() {
                const cats = this.categories.reduce((acc, category) => {
                    acc[category.id] = this.initialCategories.includes(category.id);
                    return acc;
                }, {});

                this.formCategories = cats;
                this.ready = true;
            },

            submit() {
                this.waiting = true;
                this.$store.dispatch('articles/setCategories', {
                    article_id: this.articleId,
                    category_ids: this.selected_categories
                })
                    .then(() => {
                        this.$store.dispatch('articles/fetchAll')
                            .then(() => this.$emit('categories-set'))
                            .catch(notify.error);
                        this.showForm = false;
                    })
                    .catch(console.log)
                    .then(() => this.waiting = false);
            }
        }
    }
</script>

