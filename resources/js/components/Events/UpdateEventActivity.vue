<template>
    <div v-if="pageEvent && activity" :key="$route.params.activity">
        <div class="flex justify-between items-center">
            <p class="text-lg font-bold">Edit this activity</p>
            <delete-activity :activity="activity"></delete-activity>
        </div>
        <event-activity-form :activity="activity"></event-activity-form>
    </div>
</template>

<script type="text/babel">
import EventActivityForm from "./EventActivityForm";
import DeleteActivity from "./DeleteActivity";
import { notify } from "../Messaging/notify";
export default {
    components: {
        EventActivityForm,
        DeleteActivity,
    },

    computed: {
        pageEvent() {
            return this.$store.state.events.current_page_event;
        },

        activity() {
            return this.$store.getters["events/currentEventActivityById"](
                this.$route.params.activity
            );
        },
    },

    mounted() {
        this.$store
            .dispatch("events/getCurrentPage", this.$route.params.id)
            .catch(() => notify.error({ message: "Unable to get event" }));
    },
};
</script>
