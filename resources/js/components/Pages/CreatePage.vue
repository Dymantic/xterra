<template>
    <page>
        <page-header title="Create a new Page">
            <router-link to="/pages">Back</router-link>
        </page-header>

        <page-meta-form></page-meta-form>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import PageMetaForm from "./PageMetaForm";

export default {
    components: {
        PageMetaForm,
        Page,
        PageHeader,
    },
};
</script>
