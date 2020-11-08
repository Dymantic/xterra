<template>
    <div>
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Edit Page Meta</p>
            <div class="flex justify-end">
                <router-link
                    :to="`/pages/${$route.params.page}/manage/meta`"
                    class="btn"
                    >Back</router-link
                >
            </div>
        </div>

        <page-meta-form :page="page"></page-meta-form>
    </div>
</template>

<script type="text/babel">
import PageMetaForm from "./PageMetaForm";
export default {
    components: { PageMetaForm },

    props: ["page"],
};
</script>
