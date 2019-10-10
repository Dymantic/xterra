<template>
    <span>
        <button @click="showModal = true" class="btn btn-link text-gray-600">Delete</button>
        <modal :show="showModal">
            <div class="max-w-lg p-8">
                <p class="text-lg font-bold mb-6">Are you sure?</p>
                <p>Deleting this category will remove the category from the system, but all its assosiated articles will remain.</p>
                <div class="flex justify-end mt-8">
                    <button @click="showModal = false" class="text-gray-600 bg-white mr-6">Cancel</button>
                    <button @click="deleteIt" :disabled="waiting" class="btn btn-red">Yes, delete it.</button>
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

        props: ['category-id'],

        data() {
            return {
                waiting: false,
                showModal: false,
            };
        },

        methods: {
            deleteIt() {
                this.waiting = true;
                this.$store.dispatch('articles/removeCategory', this.categoryId)
                    .then(message => {
                        notify.success(message);
                        this.$router.push('/categories');
                    })
                    .catch(notify.error)
                    .then(() => {
                        this.waiting = false;
                        this.showModal = false;
                    });
            }
        }
    }
</script>