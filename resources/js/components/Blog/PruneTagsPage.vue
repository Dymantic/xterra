<template>
    <div class="max-w-4xl mx-auto">
        <section class="flex justify-between items-center py-8">
            <h1 class="flex-1 text-5xl font-bold">Prune Tags</h1>
            <div class="flex justify-end items-center">
                <button @click="showModal = true" :disabled="prevent_delete" class="btn btn-dark">Delete Selected Tags</button>
            </div>
        </section>
        <div class="my-20 columns-3">
            <div v-for="tag in tags" :key="tag.id">
                <input type="checkbox" v-model="selected_tags" :value="tag.id" :id="`tag_${tag.id}`">
                <label :for="`tag_${tag.id}`" class="ml-2">
                    <span class="uppercase font-bold mr-4">{{ tag.tag_name }}</span>
                    <span class="text-sm text-gray-600">{{ tag.translations_count }}</span>
                </label>
            </div>
        </div>
        <modal :show="showModal" @close="showModal = false">
            <div class="p-8 max-w-md">
                <p class="text-lg font-bold">Please confirm:</p>
                <p class="my-4">You are about to delete {{ selected_tags.length }} tags. Are you sure you want to go through with this?</p>
                <div class="flex justify-end mt-6">
                    <button @click="showModal = false" class="bg-white text-gray-600 hover:text-gray-800 mr-4">Cancel</button>
                    <button :disabled="waiting" @click="pruneTags" class="btn btn-red">Yes, do it!</button>
                </div>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    import Modal from "@dymantic/modal";
    import {notify} from "../Messaging/notify";

    export default {

        components: {
            Modal,
        },

        data() {
            return {
                waiting: false,
                showModal: false,
                selected_tags: [],
            };
        },

        computed: {
            tags() {
                return this.$store.getters['articles/tagsByCount'];
            },

            prevent_delete() {
                return this.waiting || (this.selected_tags.length === 0);
            }
        },

        methods: {
            pruneTags() {
                this.waiting = true;

                this.$store.dispatch('articles/deleteTags', this.selected_tags)
                    .then(notify.success)
                    .catch(notify.error)
                    .then(() => {
                        this.waiting = false;
                        this.showModal = false;
                    });
            }
        }
    }
</script>
