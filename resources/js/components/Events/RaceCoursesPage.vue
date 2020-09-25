<template>
    <div v-if="race">
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Race Courses for {{ race.name.en }}</p>
            <div class="items-center flex">
                <router-link
                    :to="`/events/${$route.params.event}/races/${$route.params.race}/edit/courses/create`"
                    class="btn btn-dark"
                    >Add Course</router-link
                >
            </div>
        </div>

        <div class="my-12">
            <event-course-card
                v-for="course in race.courses"
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
        race() {
            return this.$store.getters["events/currentEventActivityById"](
                this.$route.params.race
            );
        },
    },
};
</script>
