<template>
    <div v-if="race && race.is_race">
        <p class="font-bold text-lg mb-6">General Schedule for this event</p>

        <schedule-organizer
            :days="race.schedule"
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
        race() {
            return this.$store.getters["events/currentEventActivityById"](
                this.$route.params.race
            );
        },
    },

    methods: {
        saveSchedule(scheduleData) {
            this.waiting = true;

            this.$store
                .dispatch("events/saveRaceSchedule", {
                    race_id: this.race.id,
                    schedule: scheduleData,
                })
                .then(() => notify.success({ message: "Schedule saved." }))
                .catch(() =>
                    notify.error({ message: "Failed to save schedule" })
                )
                .then(() => (this.waiting = false));
        },

        clearSchedule() {
            alert("yo bro");
        },
    },
};
</script>
