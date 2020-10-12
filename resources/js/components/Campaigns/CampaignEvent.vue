<template>
    <div>
        <div class="flex justify-between mb-12">
            <p class="font-bold text-lg">Campaign Event</p>
            <div class="flex justify-end">
                <event-selector @event-selected="setEvent"></event-selector>
            </div>
        </div>

        <div class="my-12">
            <language-selector v-model="lang"></language-selector>
        </div>

        <div class="my-12">
            <div v-if="!campaign.event">
                <p class="my-4 text-gray-600">
                    No event has been assigned to this campaign
                </p>
            </div>
            <div v-else>
                <event-index-card :event="campaign.event"></event-index-card>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import LanguageSelector from "../LanguageSelector";
import EventSelector from "../Events/EventSelector";
import EventIndexCard from "../Events/EventIndexCard";
import { notify } from "../Messaging/notify";
export default {
    components: { EventSelector, LanguageSelector, EventIndexCard },
    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        campaign() {
            return this.$store.getters["campaigns/byId"](
                this.$route.params.campaign
            );
        },
    },

    methods: {
        setEvent({ id }) {
            this.$store
                .dispatch("campaigns/setEvent", {
                    event_id: id,
                    campaign_id: this.campaign.id,
                })
                .then(() => notify.success({ message: "Event updated." }))
                .catch(() => notify.error({ message: "Failed to set event" }));
        },
    },
};
</script>
