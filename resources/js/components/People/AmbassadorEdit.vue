<template>
    <page v-if="ambassador">
        <page-header :title="`Edit ${ambassador.name.en}`">
            <router-link :to="`/ambassadors/${ambassador.id}/show`" class="btn"
                >Back</router-link
            >
            <delete-confirmation
                :waiting="deleting"
                @confirmed="deleteAmbassador"
                >Delete</delete-confirmation
            >
        </page-header>

        <div class="my-12">
            <ambassador-form :ambassador="ambassador"></ambassador-form>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import AmbassadorForm from "./AmbassadorForm";
import DeleteConfirmation from "../DeleteConfirmation";
import { notify } from "../Messaging/notify";
export default {
    components: {
        AmbassadorForm,
        Page,
        PageHeader,
        DeleteConfirmation,
    },

    data() {
        return {
            deleting: false,
        };
    },

    computed: {
        ambassador() {
            return this.$store.getters["ambassadors/byId"](
                this.$route.params.ambassador
            );
        },
    },

    mounted() {
        this.$store.dispatch("ambassadors/fetch");
    },

    methods: {
        deleteAmbassador() {
            this.deleting = true;

            this.$store
                .dispatch("ambassadors/delete", this.ambassador.id)
                .then(() => {
                    notify.success({ message: "Ambassador deleted" });
                    this.$router.push(`/ambassadors`);
                })
                .catch(() =>
                    notify.error({ message: "Failed to delete ambassador." })
                )
                .then(() => (this.deleting = false));
        },
    },
};
</script>
