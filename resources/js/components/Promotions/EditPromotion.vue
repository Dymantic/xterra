<template>
    <page v-if="promotion">
        <page-header :title="`Edit ${promotion.title.en}`">
            <delete-promotion :promotion="promotion"></delete-promotion>
        </page-header>
        <div>
            <promotion-form :promotion="promotion"></promotion-form>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import PromotionForm from "./PromotionForm";
import DeletePromotion from "./DeletePromotion";

export default {
    components: {
        Page,
        PageHeader,
        PromotionForm,
        DeletePromotion,
    },

    computed: {
        promotion() {
            return this.$store.getters["promotions/byId"](
                this.$route.params.promotion
            );
        },
    },

    created() {
        this.$store.dispatch("promotions/fetchAll");
    },
};
</script>
