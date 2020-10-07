<template>
    <div v-if="race" :key="`${$route.params.race}_${$route.params.lang}`">
        <fancy-editor
            :back-to="`/events/${$route.params.event}/races/${race.id}/edit/prizes`"
            upload-images-to=""
            @save="saveContent"
            :saving="waiting"
            :initial-data="race.prizes[$route.params.lang]"
            editor-title="Race Prize Table"
            instruction="Only use the Table function, and only one table. The first row will be the headers, and you don't need to make them bold"
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
                .dispatch("events/saveRacePrizes", {
                    race_id: this.$route.params.race,
                    prizes: content,
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
