<template>
    <page>
        <page-header title="Start a New Campaign"></page-header>
        <div>
            <campaign-info-form></campaign-info-form>
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
};
</script>
