<template>
    <div v-if="accommodation">
        <div class="flex items-center justify-between">
            <p class="font-bold text-lg">Edit Accommodation</p>
            <div class="items-center flex">
                <delete-accommodation
                    :accommodation="accommodation"
                ></delete-accommodation>
            </div>
        </div>
        <div>
            <accommodation-form
                :accommodation="accommodation"
            ></accommodation-form>
        </div>
    </div>
</template>

<script type="text/babel">
import AccommodationForm from "./AccommodationForm";
import DeleteAccommodation from "./DeleteAccommodation";
export default {
    components: {
        AccommodationForm,
        DeleteAccommodation,
    },

    computed: {
        accommodation() {
            return this.$store.getters["events/accommodationById"](
                this.$route.params.accommodation
            );
        },
    },
};
</script>
