<template>
    <page v-if="coach">
        <page-header :title="`Edit ${coach.name.en}`">
            <router-link :to="`/coaches/${coach.id}/show`" class="btn"
                >Back</router-link
            >
            <delete-confirmation :waiting="deleting" @confirmed="deleteCoach"
                >Delete</delete-confirmation
            >
        </page-header>

        <div class="my-12">
            <coach-form :coach="coach"></coach-form>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import CoachForm from "./CoachForm";
import DeleteConfirmation from "../DeleteConfirmation";
import { notify } from "../Messaging/notify";
export default {
    components: {
        DeleteConfirmation,
        Page,
        PageHeader,
        CoachForm,
    },

    data() {
        return {
            deleting: false,
        };
    },

    computed: {
        coach() {
            return this.$store.getters["coaches/byId"](
                this.$route.params.coach
            );
        },
    },

    mounted() {
        this.$store.dispatch("coaches/fetch");
    },

    methods: {
        deleteCoach() {
            this.deleting = true;

            this.$store
                .dispatch("coaches/delete", this.coach.id)
                .then(() => {
                    notify.success({ message: "Coach deleted" });
                    this.$router.push(`/coaches/`);
                })
                .catch(() =>
                    notify.error({ message: "Failed to delete coach." })
                )
                .then(() => (this.deleting = false));
        },
    },
};
</script>
