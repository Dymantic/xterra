<template>
    <page>
        <page-header title="Add a new Coach">
            <router-link to="/coaches" class="btn">Back</router-link>
        </page-header>

        <div class="my-12">
            <coach-form></coach-form>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import CoachForm from "./CoachForm";
export default {
    components: { CoachForm },
};
</script>
