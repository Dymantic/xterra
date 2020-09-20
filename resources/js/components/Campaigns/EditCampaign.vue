<template>
    <page v-if="campaign">
        <page-header title="Edit Campaign Info"></page-header>
        <div>
            <campaign-info-form :campaign="campaign"></campaign-info-form>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import CampaignInfoForm from "./CampaignInfoForm";
export default {
    components: {
        Page,
        PageHeader,
        CampaignInfoForm,
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
};
</script>
