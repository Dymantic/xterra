<template>
    <div class="max-w-4xl mx-auto">
        <section class="flex justify-between items-center py-8">
            <h1 class="flex-1 text-5xl font-bold">Flagged Comments</h1>
            <div class="flex justify-end items-center">

            </div>
        </section>
        <div class="text-xl text-gray-600 my-12" v-if="flagged_comments.length === 0">Nothing is currently flagged.</div>
        <div v-else class="my-12">
            <flagged-comment v-for="flagged in flagged_comments"
                             :key="flagged.id"
                             :flagged="flagged"
                             @dismiss-flag="dismissFlag"
                             @remove-comment="removeComment"
            ></flagged-comment>
        </div>
        <modal :show="showDismissModal" @close="clearDismiss">
            <div class="p-8 max-w-md">
                <p class="font-bold text-lg">Dismiss this flag</p>
                <p class="my-6">By dismissing the flag, you are deciding that there is no issue with the original comment and it can remain visible on the website.</p>
                <div class="flex justify-end mt-6">
                    <button @click="clearDismiss" class="bg-white text-gray-600 hover:text-gray-800 font-bold mr-4">Cancel</button>
                    <button :disabled="waiting" @click="doDismissal" class="btn btn-dark">Yes, Dismiss it</button>
                </div>
            </div>
        </modal>
        <modal :show="showDestroyModal" @close="clearDestroy">
            <div class="p-8 max-w-md">
                <p class="font-bold text-lg">Remove the comment</p>
                <p class="my-6">You are about to remove the original comment that was flagged by a user. This comment will no longer be shown on the website.</p>
                <div class="flex justify-end mt-6">
                    <button @click="clearDestroy" class="bg-white text-gray-600 hover:text-gray-800 font-bold mr-4">Cancel</button>
                    <button :disabled="waiting" @click="doDelete" class="btn btn-red">Yes, Delete it</button>
                </div>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    import FlaggedComment from "./FlaggedComment";
    import Modal from "@dymantic/modal";
    import {notify} from "../Messaging/notify";

    export default {

        components: {
            FlaggedComment,
            Modal,
        },

        data() {
            return {
                waiting: false,
                showDismissModal: false,
                showDestroyModal: false,
                flagged_id: null,
            };
        },

        computed: {
            flagged_comments() {
                return this.$store.state.comments.flagged;
            }
        },

        methods: {
            dismissFlag({id}) {
                this.flagged_id = id;
                this.showDismissModal = true;
            },

            doDismissal() {
              this.waiting = true;
              this.$store.dispatch('comments/dismissFlag', this.flagged_id)
                  .then()
                  .catch(notify.error)
                  .then(() => this.waiting = false)
                  .then(this.clearDismiss)
                  .then(() => notify.success({message: 'The flag has been dismissed.'}));
            },

            removeComment({id}) {
                this.flagged_id = id;
                this.showDestroyModal = true;
            },

            doDelete() {
                this.waiting = true;
                this.$store.dispatch('comments/removeFlaggedComment', this.flagged_id)
                    .then()
                    .catch(notify.error)
                    .then(() => this.waiting = false)
                    .then(this.clearDestroy)
                    .then(() => notify.success({message: 'The comment has been removed.'}));
            },

            clearDismiss() {
                this.flagged_id = null;
                this.showDismissModal = false;
            },

            clearDestroy() {
                this.flagged_id = null;
                this.showDestroyModal = false;
            }
        }
    }
</script>
