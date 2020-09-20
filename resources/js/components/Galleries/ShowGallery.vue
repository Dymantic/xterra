<template>
    <page v-if="gallery">
        <page-header :title="gallery.title.en">
            <router-link
                class="btn btn-dark"
                :to="`/galleries/${gallery.id}/edit`"
                >Edit</router-link
            >
        </page-header>

        <div class="flex justify-between items-start mb-8">
            <div class="w-1/2 mr-6">
                <p class="text-lg mb-2">{{ gallery.title.en }}</p>
                <p class="text-sm">{{ gallery.description.en }}</p>
            </div>
            <div class="w-1/2 ml-6">
                <p class="text-lg mb-2">{{ gallery.title.zh }}</p>
                <p class="text-sm">{{ gallery.description.zh }}</p>
            </div>
        </div>

        <div>
            <sortable-gallery
                title="Gallery Images"
                @sorted="handleSort"
                :upload-url="`/admin/galleries/${gallery.id}/images`"
                :images="gallery_images"
                @upload-failed="handleFailure"
                @image-cleared="handleRemoval"
                @uploaded="handleUploaded"
            ></sortable-gallery>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import SortableGallery from "../SortableGallery";
import { notify } from "../Messaging/notify";
export default {
    components: {
        Page,
        PageHeader,
        SortableGallery,
    },

    computed: {
        gallery() {
            return this.$store.getters["galleries/byId"](
                this.$route.params.gallery
            );
        },

        gallery_images() {
            return this.gallery.images
                .map((img) => ({
                    id: img.id,
                    src: img.thumb,
                    delete_url: `/admin/galleries/${this.gallery.id}/images/${img.id}`,
                    position: img.position,
                }))
                .sort((a, b) => a.position - b.position);
        },
    },

    created() {
        this.$store.dispatch("galleries/fetchGalleries");
    },

    methods: {
        handleSort(order) {
            this.$store
                .dispatch("galleries/setImageOrder", {
                    gallery_id: this.gallery.id,
                    formData: { image_ids: order },
                })
                .catch(() =>
                    notify.error({ message: "Unable to reorder images" })
                );
        },

        handleUploaded() {
            this.$store.dispatch("galleries/refreshGalleries");
        },

        handleRemoval() {
            this.$store.dispatch("galleries/refreshGalleries");
        },

        handleFailure(message) {
            notify.error({ message });
        },
    },
};
</script>
