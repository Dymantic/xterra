<template>
    <page>
        <page-header title="Create an Ambassador"></page-header>

        <div class="my-12">
            <ambassador-form></ambassador-form>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";

import AmbassadorForm from "./AmbassadorForm";
export default {
    components: { Page, PageHeader, AmbassadorForm },
};
</script>
