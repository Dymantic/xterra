<template>
    <div v-if="course">
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Edit Course</p>
            <div class="items-center flex">
                <delete-course :course="course"></delete-course>
            </div>
        </div>

        <div class="my-12">
            <event-course-form :course="course"></event-course-form>
        </div>
    </div>
</template>

<script type="text/babel">
import EventCourseForm from "./EventCourseForm";
import DeleteCourse from "./DeleteCourse";
export default {
    components: {
        EventCourseForm,
        DeleteCourse,
    },

    computed: {
        course() {
            return this.$store.getters["events/courseById"](
                this.$route.params.course
            );
        },
    },
};
</script>
