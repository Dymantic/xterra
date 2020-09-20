<template>
    <div>
        <div class="flex justify-between items-center">
            <p class="text-lg font-bold">Event Galleries</p>
            <div class="flex justify-end items-center">
                <gallery-selector
                    @gallery-selected="addGallery"
                ></gallery-selector>
            </div>
        </div>
        <div class="my-12">
            <div
                v-for="gallery in galleries"
                :key="gallery.id"
                class="p-6 my-8 shadow"
            >
                <event-gallery-card :gallery="gallery"></event-gallery-card>
                <div class="mt-4 flex justify-end">
                    <router-link
                        :to="`/galleries/${gallery.id}/show`"
                        class="font-bold hover:text-blue-600 mx-4"
                        >View Gallery</router-link
                    >
                    <submit-button
                        :waiting="removing"
                        role="button"
                        mode="danger"
                        @click.native="removeGallery(gallery)"
                        >Remove</submit-button
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import GallerySelector from "../Galleries/GallerySelector";
import EventGalleryCard from "./EventGalleryCard";
import SubmitButton from "../Forms/SubmitButton";
import { notify } from "../Messaging/notify";
export default {
    components: {
        GallerySelector,
        EventGalleryCard,
        SubmitButton,
    },

    data() {
        return {
            removing: false,
        };
    },

    computed: {
        galleries() {
            return this.$store.getters["events/currentEventGalleries"];
        },
    },

    created() {},

    methods: {
        addGallery({ id }) {
            this.$store
                .dispatch("events/attachGallery", {
                    event_id: this.$route.params.id,
                    gallery_id: id,
                })
                .then(() => notify.success({ message: "Gallery attached." }))
                .catch(() =>
                    notify.error({ message: "Unable to attach gallery." })
                );
        },

        removeGallery({ id }) {
            this.removing = true;
            this.$store
                .dispatch("events/removeGallery", {
                    event_id: this.$route.params.id,
                    gallery_id: id,
                })
                .then(() => notify.success({ message: "Gallery removed." }))
                .catch(() =>
                    notify.error({ message: "Unable to remove gallery." })
                )
                .then(() => (this.removing = false));
        },
    },
};
</script>
