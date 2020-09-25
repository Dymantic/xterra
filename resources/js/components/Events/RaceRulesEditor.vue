<template>
    <div v-if="race" :key="`${$route.params.race}_${$route.params.lang}`">
        <fancy-editor
            v-if="race"
            :back-to="`/events/${$route.params.event}/races/${race.id}/edit/rules/show`"
            :upload-images-to="`/admin/races/${race.id}/content-images`"
            @save="saveContent"
            :saving="waiting"
            :initial-data="race.race_rules[$route.params.lang]"
            editor-title="Race Rules"
        ></fancy-editor>
    </div>
</template>

<script type="text/babel">
import FancyEditor from "../FancyEditor";
import { notify } from "../Messaging/notify";
export default {
    components: { FancyEditor },

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
        saveContent(content) {
            this.waiting = true;

            this.$store
                .dispatch("events/saveRaceRules", {
                    race_id: this.$route.params.race,
                    rules: content,
                    lang: this.$route.params.lang,
                })
                .then(() => notify.success({ message: "Content saved" }))
                .catch(() =>
                    notify.error({ message: "Failed to save content" })
                )
                .then(() => (this.waiting = false));
        },
    },
};
</script>
