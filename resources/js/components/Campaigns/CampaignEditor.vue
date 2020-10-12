<template>
    <fancy-editor
        v-if="campaign"
        :back-to="`/campaigns/${campaign.id}/show/content`"
        :upload-images-to="`/admin/campaigns/${campaign.id}/narrative-images`"
        @save="saveContent"
        :saving="waiting"
        :initial-data="campaign.narrative_raw[this.$route.params.lang]"
        :editor-title="campaign.title[this.$route.params.lang]"
    ></fancy-editor>
</template>

<script type="text/babel">
import FancyEditor from "../FancyEditor";
import { notify } from "../Messaging/notify";
export default {
    components: {
        FancyEditor,
    },

    data() {
        return {
            waiting: false,
        };
    },

    computed: {
        campaign() {
            return this.$store.getters["campaigns/byId"](
                this.$route.params.campaign
            );
        },
    },

    created() {
        this.$store.dispatch("campaigns/fetchAll");
    },

    methods: {
        saveContent(content) {
            this.waiting = true;
            this.$store
                .dispatch("campaigns/updateNarrative", {
                    campaign_id: this.campaign.id,
                    formData: {
                        narrative: { content, lang: this.$route.params.lang },
                    },
                })
                .then(() => notify.success({ message: "Saved contents" }))
                .catch(() =>
                    notify.error({ message: "Failed to save contents" })
                )
                .then(() => (this.waiting = false));
        },
    },
};
</script>
