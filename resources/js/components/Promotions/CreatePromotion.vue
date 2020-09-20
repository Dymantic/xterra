<template>
    <page>
        <page-header title="Create a Promotion"></page-header>

        <div>
            <promotion-form></promotion-form>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import PromotionForm from "./PromotionForm";
export default {
    components: {
        Page,
        PageHeader,
        PromotionForm,
    },
};
</script>
