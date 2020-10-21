<template>
    <div v-if="sponsor">
        <div class="flex justify-between items-center mb-12">
            <p class="text-lg font-bold">Edit Sponsor</p>
            <div></div>
        </div>
        <div>
            <sponsor-form :sponsor="sponsor"></sponsor-form>
        </div>
    </div>
</template>

<script type="text/babel">
import SponsorForm from "./SponsorForm";
export default {
    components: {
        SponsorForm,
    },

    computed: {
        sponsor() {
            return this.$store.getters["events/sponsorById"](
                this.$route.params.sponsor
            );
        },
    },
};
</script>
