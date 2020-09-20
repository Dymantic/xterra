<template>
    <div v-if="course">
        <sortable-gallery
            :title="`${course.name.en} Gallery`"
            @sorted="handleSort"
            :upload-url="`/admin/courses/${course.id}/images`"
            :images="images"
            @upload-failed="handleFailure"
            @image-cleared="handleRemoval"
            @uploaded="handleUploaded"
        ></sortable-gallery>
    </div>
</template>

<script type="text/babel">
import SortableGallery from "../SortableGallery";
import { notify } from "../Messaging/notify";
export default {
    components: {
        SortableGallery,
    },

    computed: {
        course() {
            return this.$store.getters["events/courseById"](
                this.$route.params.course
            );
        },

        images() {
            return this.course.gallery
                .map((img) => ({
                    id: img.id,
                    src: img.thumb,
                    delete_url: `/admin/courses/${this.course.id}/images/${img.id}`,
                    position: img.position,
                }))
                .sort((a, b) => a.position - b.position);
        },
    },

    methods: {
        handleSort(order) {
            this.$store
                .dispatch("events/setCourseImagePositions", {
                    course_id: this.course.id,
                    image_ids: order,
                })
                .catch(() =>
                    notify.error({ message: "Unable to save image order" })
                );
        },

        handleFailure(message) {
            notify.error({ message });
        },

        handleUploaded() {
            this.$store.dispatch("events/refreshEvents");
        },

        handleRemoval() {
            this.$store.dispatch("events/refreshEvents");
        },
    },
};
</script>
