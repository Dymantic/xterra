<template>
    <div v-if="sponsor">
        <div class="flex justify-between items-center mb-12">
            <p class="text-lg font-bold">Edit Sponsor</p>
            <div>
                <delete-sponsor :sponsor="sponsor"></delete-sponsor>
            </div>
        </div>
        <div>
            <sponsor-form :sponsor="sponsor"></sponsor-form>
        </div>
    </div>
</template>

<script type="text/babel">
import SponsorForm from "./SponsorForm";
import DeleteSponsor from "./DeleteSponsor";
export default {
    components: {
        DeleteSponsor,
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
