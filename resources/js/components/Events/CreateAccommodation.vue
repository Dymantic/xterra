<template>
    <div>
        <div class="flex items-center justify-between">
            <p class="font-bold text-lg">Add new Accommodation</p>
        </div>
        <div>
            <accommodation-form></accommodation-form>
        </div>
    </div>
</template>

<script type="text/babel">
import AccommodationForm from "./AccommodationForm";
export default {
    components: {
        AccommodationForm,
    },
};
</script>
