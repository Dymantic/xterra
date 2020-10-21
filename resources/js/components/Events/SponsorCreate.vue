<template>
    <div>
        <div class="flex justify-between items-center mb-12">
            <p class="text-lg font-bold">Add a New Sponsor</p>
            <div>
                <router-link
                    :to="`/events/${$route.params.id}/edit/sponsors`"
                    class="btn"
                    >Back</router-link
                >
            </div>
        </div>
        <div>
            <sponsor-form></sponsor-form>
        </div>
    </div>
</template>

<script type="text/babel">
import SponsorForm from "./SponsorForm";
export default {
    components: { SponsorForm },
};
</script>
