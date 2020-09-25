<template>
    <div v-if="race" :key="`${$route.params.race}_${$route.params.lang}`">
        <fancy-editor
            v-if="race"
            :back-to="`/events/${$route.params.event}/races/${race.id}/edit/description/show`"
            upload-images-to=""
            @save="saveContent"
            :saving="waiting"
            :initial-data="race.description[$route.params.lang]"
            editor-title="Race Description"
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
                .dispatch("events/saveRaceDescription", {
                    race_id: this.$route.params.race,
                    description: content,
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
