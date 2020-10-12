<template>
    <div>
        <div class="flex justify-between mb-12">
            <p class="font-bold text-lg">Homepage Event</p>
            <div class="flex justify-end">
                <event-selector @event-selected="setEvent"></event-selector>
            </div>
        </div>

        <event-index-card
            :event="homePage.event"
            v-if="homePage.event"
        ></event-index-card>
    </div>
</template>

<script type="text/babel">
import { notify } from "../Messaging/notify";
import EventSelector from "../Events/EventSelector";
import EventIndexCard from "../Events/EventIndexCard";

export default {
    components: { EventIndexCard, EventSelector },
    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        homePage() {
            return this.$store.state.homepage.homepage;
        },
    },

    methods: {
        setEvent({ id }) {
            this.$store
                .dispatch("homepage/attachEvent", id)
                .catch(() =>
                    notify.error({ message: "Failed to attach event" })
                );
        },
    },
};
</script>
