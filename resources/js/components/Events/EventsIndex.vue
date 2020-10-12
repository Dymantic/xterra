<template>
    <page>
        <page-header title="XTERRA Events">
            <create-event-form></create-event-form>
        </page-header>
        <div class="flex flex-col items-start">
            <event-index-card
                v-for="event in events_list"
                :key="event.id"
                :event="event"
            ></event-index-card>
        </div>
    </page>
</template>

<script type="text/babel">
import CreateEventForm from "./CreateEventForm";
import EventIndexCard from "./EventIndexCard";
export default {
    components: {
        CreateEventForm,
        EventIndexCard,
    },

    computed: {
        events_list() {
            return this.$store.state.events.all;
        },
    },

    mounted() {
        this.$store.dispatch("events/fetchAll");
    },
};
</script>
