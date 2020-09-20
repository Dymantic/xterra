<template>
    <div class="shadow my-6 p-6 relative">
        <p class="font-bold">{{ course.name.en }} - {{ course.distance.en }}</p>
        <p class="text-gray-600">
            {{ course.name.zh }} - {{ course.distance.zh }}
        </p>

        <div class="flex justify-between">
            <p class="my-4 text-sm w-1/2 mr-4">
                {{ course.description.en }}
            </p>
            <p class="my-4 text-sm w-1/2 ml-4">
                {{ course.description.zh }}
            </p>
        </div>

        <div>
            <single-file-upload
                class="border-t border-gray-300 pt-2"
                :upload-path="`/admin/courses/${course.id}/gpx-file`"
                :delete-path="`/admin/courses/${course.id}/gpx-file`"
                :download-path="`${course.gpx_file}`"
                :filename="gpx_filename"
                name="gpx_file"
                prompt="Upload a .gpx file for this course"
                @uploaded="handleUpload"
                @upload-failed="handleError"
                @invalid-file="handleInvalid"
                @cleared="handleCleared"
                @clear-failed="handleClearError"
            ></single-file-upload>
        </div>

        <div class="absolute top-0 right-0 mt-4 mr-4">
            <router-link
                class="font-bold hover:text-blue-600"
                :to="`/events/${$route.params.id}/edit/courses/${course.id}/edit`"
                >Edit</router-link
            >
            <router-link
                class="font-bold hover:text-blue-600 ml-4"
                :to="`/events/${$route.params.id}/edit/courses/${course.id}/gallery`"
                >Gallery</router-link
            >
        </div>
    </div>
</template>

<script type="text/babel">
import SingleFileUpload from "../SingleFileUpload";
import { notify } from "../Messaging/notify";
export default {
    components: {
        SingleFileUpload,
    },

    props: ["course"],

    computed: {
        gpx_filename() {
            return `${this.course.name.en.replace(/ /g, "_")}.gpx`;
        },
    },

    methods: {
        handleUpload() {
            notify.success({ message: "GPX file uploaded" });
            this.$store.dispatch("events/refreshEvents");
        },

        handleInvalid(message) {
            notify.warn({ message });
        },

        handleError(message) {
            notify.error({ message });
        },

        handleCleared() {
            notify.success({ message: "GPX file removed" });
            this.$store.dispatch("events/refreshEvents");
        },

        handleClearError() {
            notify.error({ message: "Unable to remove file" });
        },
    },
};
</script>
