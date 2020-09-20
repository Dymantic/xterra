<template>
    <div v-if="pageEvent">
        <div class="flex justify-between items-center mb-12">
            <p class="text-lg font-bold">Event Activities and Races</p>
            <router-link
                class="btn btn-dark"
                :to="`/events/${pageEvent.id}/edit/activities/create`"
                >Add activity</router-link
            >
        </div>
        <div class="my-8 flex">
            <radio-input
                v-model="lang"
                label="English"
                thing="en"
                class="mr-8"
            ></radio-input>
            <radio-input
                v-model="lang"
                label="Chinese"
                thing="zh"
            ></radio-input>
        </div>
        <div>
            <activity
                v-for="activity in pageEvent.activities"
                :key="activity.id"
                :activity="activity"
                :lang="lang"
                :event-id="pageEvent.id"
            ></activity>
        </div>
    </div>
</template>

<script type="text/babel">
import Activity from "./Activity";
import RadioInput from "../Forms/RadioInput";
import { notify } from "../Messaging/notify";

export default {
    components: {
        Activity,
        RadioInput,
    },

    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        pageEvent() {
            return this.$store.state.events.current_page_event;
        },
    },

    mounted() {
        this.$store
            .dispatch("events/getCurrentPage", this.$route.params.id)
            .catch(() => notify.error({ message: "Unable to get event" }));
    },
};
</script>
