<template>
    <div v-if="event">
        <fees-list
            :fees="event.fees"
            :waiting="waiting"
            @save="saveFees"
        ></fees-list>
    </div>
</template>

<script type="text/babel">
import FeesList from "./FeesList";
import { notify } from "../Messaging/notify";

export default {
    components: {
        FeesList,
    },

    data() {
        return {
            waiting: false,
        };
    },

    computed: {
        event() {
            return this.$store.state.events.current_page_event;
        },
    },

    methods: {
        saveFees(fees) {
            this.waiting = true;
            this.$store
                .dispatch("events/saveFees", {
                    event_id: this.$route.params.id,
                    fees,
                })
                .then(() => notify.success({ message: "Fees updated" }))
                .catch(() =>
                    notify.error({
                        message: "Failed to save fees info",
                    })
                )
                .then(() => (this.waiting = false));
        },
    },
};
</script>
