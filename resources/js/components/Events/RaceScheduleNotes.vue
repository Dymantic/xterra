<template>
    <div v-if="race">
        <p class="font-bold text-lg">Schedule notes: {{ race.name.en }}</p>

        <div>
            <notes-editor
                :initial="race.schedule_notes"
                :waiting="waiting"
                @save="saveNotes"
            ></notes-editor>
        </div>
    </div>
</template>

<script type="text/babel">
import NotesEditor from "./NotesEditor";
import { notify } from "../Messaging/notify";
export default {
    components: {
        NotesEditor,
    },

    computed: {
        race() {
            return this.$store.getters["events/currentEventActivityById"](
                this.$route.params.race
            );
        },
    },

    data() {
        return {
            waiting: false,
        };
    },

    methods: {
        saveNotes(notes) {
            this.waiting = true;

            this.$store
                .dispatch("events/saveScheduleNotes", {
                    race_id: this.$route.params.race,
                    notes,
                })
                .then(() => notify.success({ message: "Notes saved" }))
                .catch(() => notify.error({ message: "Unable to save notes" }))
                .then(() => (this.waiting = false));
        },
    },
};
</script>
