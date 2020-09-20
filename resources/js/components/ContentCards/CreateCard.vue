<template>
    <page>
        <page-header title="Create a Content Card"></page-header>

        <div>
            <card-form></card-form>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import CardForm from "./CardForm";

export default {
    components: {
        Page,
        PageHeader,
        CardForm,
    },

    created() {
        this.$store.dispatch("cards/fetchAll");
    },
};
</script>
