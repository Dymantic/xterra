<template>
    <div class="max-w-4xl mx-auto">
        <section class="flex justify-between items-center py-8">
            <h1 class="flex-1 text-5xl font-bold">Review Comments</h1>
            <div class="flex justify-end items-center">

            </div>
        </section>
        <div class="my-6 flex items-center">
            <p>You are reviewing comments from {{ comments_from }} - {{ comments_to }}</p>
            <button class="ml-6 text-gray-600 hover:text-red-500 text-sm" @click="showDatePickers = true">Change dates</button>
            <modal :show="showDatePickers" @close="closeAndUpdate">
                <div class="p-8">
                    <p class="mb-6 text-lg font-bold">Select date range to review.</p>
                    <div class="flex">

                        <div class="mr-4">
                            <p>From:</p>
                            <date-picker @selected="setStartDate" :value="start_date" :inline="true"></date-picker>
                        </div>
                        <div class="ml-4">
                            <p>To:</p>
                            <date-picker @selected="setEndDate" :value="end_date" :inline="true"></date-picker>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button @click="closeAndUpdate" class="btn btn-dark">Done</button>
                    </div>

                </div>
            </modal>
        </div>
        <div class="my-20 bg-white p-8">
            <div v-for="comment in comments" :key="comment.unique" class="my-6 pb-6 border-b">
                <div class="flex justify-between">
                    <div class="flex mb-2">
                        <span class="text-gray-600 uppercase text-sm mr-6">{{ comment.type }}</span>
                        <span class="text-sm font-bold mr-6">{{ comment.when }}</span>
                        <span class="text-sm">{{ comment.author }}</span>
                    </div>
                    <button @click="setDeleteItem(comment)" class="text-sm hover:text-red-500">Delete</button>
                </div>

                <div class="border-l-2 border-gray-800 pl-4 py-2 text-lg bg-gray-100" v-html="comment.body"></div>
                <div class="mt-2">
                    <p v-if="comment.type === 'comment'">From article: </p>
                    <p v-else>Original comment: </p>

                    <div v-html="comment.context"></div>
                </div>
            </div>
        </div>
        <modal :show="showModal" @close="clearSelectedComment">
            <div class="p-8 max-w-md">
                <p class="text-lg font-bold">Are you sure?</p>
                <p class="my-3 text-sm">You are about to delete the following comment:</p>
                <div class="max-h-48 overflow-auto bg-gray-100 p-2" v-if="selected_comment" v-html="selected_comment.body"></div>
                <div class="flex justify-end mt-6">
                    <button @click="clearSelectedComment" class="bg-white text-gray-600 hover:text-gray-800 mr-4">Cancel</button>
                    <button class="btn btn-red" @click="deleteItem">Yes, delete it.</button>
                </div>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    import Modal from "@dymantic/modal";
    import DatePicker from "vuejs-datepicker";
    import {notify} from "../Messaging/notify";

    export default {

        components: {
            Modal,
            DatePicker,
        },

        data() {
            return {
                showModal: false,
                showDatePickers: false,
                selected_comment: null,
            };
        },

        computed: {
            comments() {
                return this.$store.getters['comments/reviewable'];
            },

            comments_from() {
                return this.$store.getters['comments/date_from'];
            },

            comments_to() {
                return this.$store.getters['comments/date_to'];
            },

            start_date() {
                return this.$store.state.comments.start_date;
            },

            end_date() {
                return this.$store.state.comments.end_date;
            }
        },

        methods: {
            setStartDate(date) {
                console.log(date);
                this.$store.commit('comments/set_start', date);
            },

            setEndDate(date) {
                console.log(date);
                this.$store.commit('comments/set_end', date);
            },

            closeAndUpdate() {
                this.$store.dispatch('comments/hydrate');
                this.showDatePickers = false;
            },

            setDeleteItem(comment) {
                this.selected_comment = comment;
                this.showModal = true;
            },

            clearSelectedComment() {
                this.selected_comment = null;
                this.showModal = false;
            },

            deleteItem() {
                if(!this.selected_comment) {
                    return;
                }

                if(this.selected_comment.type === 'comment') {
                    this.$store.dispatch('comments/deleteComment', this.selected_comment.id)
                        .then(() => notify.success({message: 'Comment has been deleted'}))
                        .catch(notify.error)
                        .then(this.clearSelectedComment);

                    return;
                }

                this.$store.dispatch('comments/deleteReply', this.selected_comment.id)
                    .then(() => notify.success({message: 'Reply has been deleted'}))
                    .catch(notify.error)
                    .then(this.clearSelectedComment);
            }
        }
    }
</script>
