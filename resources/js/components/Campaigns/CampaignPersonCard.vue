<template>
    <div class="my-6 mr-6 shadow w-64" v-show="!deleting">
        <img :src="person.profile_pic.thumb" class="w-full" />

        <div v-show="!request_delete" class="flex justify-between p-2">
            <p class="font-semibold text-sm">
                <router-link :to="person_url" class="hover:text-blue-600">
                    {{ person.name.en }}
                </router-link>
            </p>
            <button class="text-sm" @click="request_delete = true">
                Delete
            </button>
        </div>

        <div v-show="request_delete" class="flex justify-between p-2">
            <p class="font-semibold text-sm">Are you sure?</p>
            <div>
                <button
                    type="button"
                    class="text-sm hover:text-blue-600 mx-3"
                    @click="deletePerson"
                >
                    Yes
                </button>
                <button
                    type="button"
                    class="text-sm hover:text-blue-600 mx-3"
                    @click="request_delete = false"
                >
                    No
                </button>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import { notify } from "../Messaging/notify";

export default {
    props: ["person", "type", "relation-id", "relation-type"],

    data() {
        return {
            request_delete: false,
            deleting: false,
        };
    },

    computed: {
        person_url() {
            if (this.type === "ambassador") {
                return `/ambassadors/${this.person.id}/show`;
            }

            if (this.type === "coach") {
                return `/coaches/${this.person.id}/show`;
            }
        },

        delete_action() {
            if (this.type === "ambassador") {
                return `${this.relationType}s/detachAmbassador`;
            }

            if (this.type === "coach") {
                return `${this.relationType}s/detachCoach`;
            }
        },

        delete_payload() {
            const payload = {};
            payload[`${this.relationType}_id`] = this.relationId;
            if (this.type === "ambassador") {
                payload.ambassador_id = this.person.id;
            }

            if (this.type === "coach") {
                payload.coach_id = this.person.id;
            }

            return payload;
        },
    },

    methods: {
        deletePerson() {
            this.deleting = true;

            this.$store
                .dispatch(this.delete_action, this.delete_payload)
                .then(() => notify.success({ message: "Person removed" }))
                .catch(() => {
                    this.deleting = false;
                    notify.error({
                        message: "Failed to remove person from campaign",
                    });
                });
        },
    },
};
</script>
