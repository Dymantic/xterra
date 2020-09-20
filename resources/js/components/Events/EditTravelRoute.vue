<template>
    <div v-if="travelRoute">
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Edit Travel Route</p>
            <div class="items-center flex">
                <delete-travel-route
                    :travel-route="travelRoute"
                ></delete-travel-route>
            </div>
        </div>
        <div>
            <travel-route-form :travel-route="travelRoute"></travel-route-form>
        </div>
    </div>
</template>

<script type="text/babel">
import TravelRouteForm from "./TravelRouteForm";
import DeleteTravelRoute from "./DeleteTravelRoute";
export default {
    components: {
        TravelRouteForm,
        DeleteTravelRoute,
    },

    computed: {
        travelRoute() {
            return this.$store.getters["events/travelRouteById"](
                this.$route.params.travelRoute
            );
        },
    },
};
</script>
