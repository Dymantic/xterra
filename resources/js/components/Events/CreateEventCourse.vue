<template>
    <div v-if="race">
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Add New Event Courses</p>
            <div class="items-center flex"></div>
        </div>

        <div class="my-12">
            <event-course-form :race="race"></event-course-form>
        </div>
    </div>
</template>

<script type="text/babel">
import EventCourseForm from "./EventCourseForm";
export default {
    components: {
        EventCourseForm,
    },

    computed: {
        race() {
            return this.$store.getters["events/currentEventActivityById"](
                this.$route.params.race
            );
        },
    },
};
</script>
