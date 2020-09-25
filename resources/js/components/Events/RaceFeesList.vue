<template>
    <div v-if="race">
        <fees-list
            :fees="race.fees"
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
        race() {
            return this.$store.getters["events/currentEventActivityById"](
                this.$route.params.race
            );
        },
    },

    methods: {
        saveFees(fees) {
            this.waiting = true;
            this.$store
                .dispatch("events/saveRaceFees", {
                    race_id: this.$route.params.race,
                    fees,
                })
                .then(() => notify.success({ message: "Fees updated" }))
                .catch(() =>
                    notify.error({ message: "Failed to save fees info" })
                )
                .then(() => (this.waiting = false));
        },
    },
};
</script>
