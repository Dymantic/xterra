<template>
    <div>
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Add New Event Courses</p>
            <div class="items-center flex"></div>
        </div>

        <div class="my-12">
            <event-course-form></event-course-form>
        </div>
    </div>
</template>

<script type="text/babel">
import EventCourseForm from "./EventCourseForm";
export default {
    components: {
        EventCourseForm,
    },
};
</script>
