<template>
    <page>
        <page-header title="Create a Gallery"></page-header>

        <div>
            <gallery-form></gallery-form>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import GalleryForm from "./GalleryForm";
export default {
    components: {
        Page,
        PageHeader,
        GalleryForm,
    },
};
</script>
