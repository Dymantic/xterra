<template>
    <span>
        <button class="btn btn-red" @click="showDeleteForm = true">Delete</button>
        <modal :show="showDeleteForm" @close="showDeleteForm = false">
            <div class="p-8 max-w-md">
                <p class="text-red-500 font-bold text-xl">Are you very, very sure?</p>
                <p class="my-6">By deleting this article you will also delete any translations you may have. You will never be able to get them back.</p>
                <form @submit.prevent="submit" class="flex justify-end mt-6">
                    <button class="mr-4 bg-white text-gray-600 hover:text-gray-800" type="button" @click="showDeleteForm = false">Cancel</button>
                    <button type="submit" class="btn btn-red">Yes, delete it!</button>
                </form>
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

        props: ['article-id'],

        data() {
            return {
                showDeleteForm: false,
            };
        },

        methods: {
            submit() {
                this.$store.dispatch('articles/deleteArticle', this.articleId)
                    .then(() => {
                        notify.success({message: 'Article has been deleted'});
                        this.$router.push('/articles');
                    })
                    .catch(notify.error)
                    .then(() => this.showDeleteForm = false);
            }
        }
    }
</script>
