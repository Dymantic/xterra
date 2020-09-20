<template>
    <div>
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Add a Travel Route</p>
            <div class="items-center flex"></div>
        </div>
        <div>
            <travel-route-form></travel-route-form>
        </div>
    </div>
</template>

<script type="text/babel">
import TravelRouteForm from "./TravelRouteForm";
export default {
    components: {
        TravelRouteForm,
    },
};
</script>
