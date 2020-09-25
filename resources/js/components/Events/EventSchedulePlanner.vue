<template>
    <div v-if="schedule">
        <p class="font-bold text-lg mb-6">General Schedule for this event</p>

        <schedule-organizer
            :days="schedule"
            :waiting="waiting"
            @save="saveSchedule"
            @clear="clearSchedule"
        ></schedule-organizer>
    </div>
</template>

<script type="text/babel">
import ScheduleOrganizer from "./ScheduleOrganizer";
import { notify } from "../Messaging/notify";
export default {
    components: {
        ScheduleOrganizer,
    },

    data() {
        return {
            waiting: false,
        };
    },

    computed: {
        schedule() {
            return this.$store.getters["events/currentEventSchedule"];
        },
    },

    methods: {
        saveSchedule(scheduleData) {
            this.waiting = true;

            this.$store
                .dispatch("events/saveSchedule", {
                    event_id: this.$route.params.id,
                    schedule: scheduleData,
                })
                .then(() => notify.success({ message: "Schedule updated." }))
                .catch(() =>
                    notify.error({ message: "Failed to update schedule" })
                )
                .then(() => (this.waiting = false));
        },

        clearSchedule() {
            this.waiting = true;
            this.$store
                .dispatch("events/clearSchedule", this.$route.params.id)
                .then(() => notify.success({ message: "Schedule cleared." }))
                .catch(() =>
                    notify.error({ message: "Failed to clear schedule" })
                )
                .then(() => (this.waiting = false));
        },
    },
};
</script>
