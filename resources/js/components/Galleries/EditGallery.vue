<template>
    <page v-if="gallery">
        <page-header :title="`Edit ${gallery.title.en}`">
            <delete-gallery :gallery="gallery"></delete-gallery>
        </page-header>

        <div>
            <gallery-form :gallery="gallery"></gallery-form>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import GalleryForm from "./GalleryForm";
import DeleteGallery from "./DeleteGallery";

export default {
    components: {
        Page,
        PageHeader,
        GalleryForm,
        DeleteGallery,
    },

    computed: {
        gallery() {
            return this.$store.getters["galleries/byId"](
                this.$route.params.gallery
            );
        },
    },

    created() {
        this.$store.dispatch("galleries/fetchGalleries");
    },
};
</script>
