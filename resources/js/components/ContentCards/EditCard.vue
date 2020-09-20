<template>
    <page v-if="card">
        <page-header title="Edit Card">
            <router-link class="btn mx-4" :to="`/content-cards/${card.id}`"
                >&larr; back</router-link
            >
            <delete-card :card="card"></delete-card>
        </page-header>
        <div>
            <card-form :card="card"></card-form>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import CardForm from "./CardForm";
import DeleteCard from "./DeleteCard";

export default {
    components: {
        Page,
        PageHeader,
        CardForm,
        DeleteCard,
    },

    computed: {
        card() {
            return this.$store.getters["cards/byId"](this.$route.params.card);
        },
    },

    created() {
        this.$store.dispatch("cards/fetchAll");
    },
};
</script>
