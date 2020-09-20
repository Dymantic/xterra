<template>
    <span>
        <button type="button" @click="showModal = true" class="btn btn-danger">
            Delete
        </button>
        <modal :show="showModal" @close="showModal = false">
            <div class="p-6 max-w-md w-screen">
                <p class="text-lg font-bold text-red-600">Are you sure?</p>
                <p class="my-6">
                    You are about to delete {{ accommodation.name.en }}. It will
                    be removed.
                </p>
                <div class="flex justify-end mt-6">
                    <button @click="showModal = false" class="btn mr-4">
                        Cancel
                    </button>
                    <submit-button
                        :waiting="waiting"
                        role="button"
                        mode="danger"
                        @click.native="deleteAccommodation"
                        >Yes, delete it!</submit-button
                    >
                </div>
            </div>
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

    props: ["accommodation"],

    data() {
        return {
            waiting: false,
            showModal: false,
        };
    },

    methods: {
        deleteAccommodation() {
            this.waiting = true;

            this.$store
                .dispatch("events/removeAccommodation", this.accommodation.id)
                .then(() => {
                    this.showModal = false;
                    notify.success({ message: "Accommodation deleted" });
                    this.$router.push(
                        `/events/${this.$route.params.id}/edit/accommodation`
                    );
                })
                .catch(() => {
                    this.showModal = false;
                    notify.error({
                        message: "Failed to delete accommodation.",
                    });
                })
                .then(() => (this.waiting = false));
        },
    },
};
</script>
