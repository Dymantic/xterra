<template>
    <span>
        <button @click="showForm = true" class="btn btn-red">Delete</button>
        <modal :show="showForm" @close="showForm = false">
            <form @submit.prevent="submit" class="w-screen max-w-md p-6">
                <p class="text-lg font-bold text-red-700">Are you sure?</p>
                <p class="my-4">
                    You are about to delete {{ campaign.title.en }}. This can
                    not be undone.
                </p>
                <div class="mt-6 flex justify-end">
                    <button
                        type="button"
                        class="btn mr-4"
                        @click="showForm = false"
                    >
                        Cancel
                    </button>
                    <submit-button :waiting="waiting" mode="danger"
                        >Yes, Delete it</submit-button
                    >
                </div>
            </form>
        </modal>
    </span>
</template>

<script type="text/babel">
import SubmitButton from "../Forms/SubmitButton";
import { notify } from "../Messaging/notify";
export default {
    components: {
        SubmitButton,
    },

    props: ["campaign"],

    data() {
        return {
            waiting: false,
            showForm: false,
        };
    },

    methods: {
        submit() {
            this.waiting = true;
            this.$store
                .dispatch("campaigns/delete", this.campaign.id)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            notify.success({ message: "Campaign deleted" });
            this.showForm = false;
            this.$router.push(`/campaigns`);
        },

        onError() {
            notify.error({ message: "Unable to delete campaign" });
            this.showForm = false;
        },
    },
};
</script>
