<template>
    <div>
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Event Courses</p>
            <div class="items-center flex">
                <router-link
                    :to="`/events/${$route.params.id}/edit/courses/create`"
                    class="btn btn-dark"
                    >Add Course</router-link
                >
            </div>
        </div>

        <div class="my-12">
            <event-course-card
                v-for="course in courses"
                :key="course.id"
                :course="course"
            ></event-course-card>
        </div>
    </div>
</template>

<script type="text/babel">
import EventCourseCard from "./EventCourseCard";
import { notify } from "../Messaging/notify";
export default {
    components: {
        EventCourseCard,
    },

    computed: {
        courses() {
            return this.$store.getters["events/currentEventCourses"];
        },
    },
};
</script>
