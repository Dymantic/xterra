<template>
    <div v-if="fetched" class="max-w-4xl mx-auto">
        <section class="flex justify-between items-center py-8">
            <h1 class="flex-1 text-5xl font-bold">{{ user.name }}</h1>
            <div class="flex justify-end items-center">

            </div>
        </section>
        <div v-if="!user.is_retired" class="max-w-4xl mx-auto p-8 bg-white shadow-lg">
            <p class="font-bold text-lg text-gray-800">Retire this user</p>
            <p class="my-4 max-w-xl">Retiring this user will prevent them from being able to log into the system in the future, and they will no longer have access to any of the content. Articles they have contributed will still remain.</p>
            <button @click="showDeleteForm = true" class="btn btn-red mt-8">Remove user</button>
            <modal :show="showDeleteForm" @close="showDeleteForm = false">
                <div class="p-8 max-w-lg">
                    <p class="text-lg font-bold">Are you sure?</p>
                    <p class="my-4">This step can't be taken back lightly. Make sure you are certain that you want to do this.</p>
                    <div class="flex items-center justify-end mt-8">
                        <button v-if="!waiting" @click="showDeleteForm = false" class="text-gray-600 hover:text-blue-600 bg-white mr-4">Nope, cancel.</button>
                        <button @click="retire" :disabled="waiting" class="btn btn-red">Yes, do it!</button>
                    </div>
                </div>
            </modal>
        </div>
        <div v-else class="max-w-4xl mx-auto p-8 bg-white shadow-lg">
            <p class="font-bold text-lg text-gray-800">Retired</p>
            <p class="my-4 max-w-xl">{{ user.name }} has been retired from the system since {{ user.retired_date }}</p>
        </div>
    </div>
</template>

<script type="text/babel">
    import {notify} from "../Messaging/notify";
    import Modal from "@dymantic/modal";

    export default {
        components: {
            Modal,
        },

        data() {
            return {
                waiting: false,
                fetched: false,
                showDeleteForm: false,
                user: null,
            };
        },

        computed: {
            user_id() {
                return this.$route.params.id;
            }
        },

        mounted() {
            this.getUser();
        },

        methods: {
            getUser() {
                this.$store.dispatch('users/fetchUser', this.user_id)
                    .then(user => {
                        this.user = user;
                        this.fetched = true;
                    })
                    .catch(notify.error);
            },

            retire() {
                this.waiting = true;
                this.$store.dispatch('users/retire', this.user)
                    .then(user => this.user = user)
                    .catch(notify.error)
                    .then(() => {
                        this.waiting = false;
                        this.showDeleteForm = false;
                    });
            }
        }
    }
</script>

