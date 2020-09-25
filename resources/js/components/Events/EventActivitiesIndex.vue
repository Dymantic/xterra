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
            <language-selector v-model="lang"></language-selector>
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
import LanguageSelector from "../LanguageSelector";
import { notify } from "../Messaging/notify";

export default {
    components: {
        Activity,
        RadioInput,
        LanguageSelector,
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
