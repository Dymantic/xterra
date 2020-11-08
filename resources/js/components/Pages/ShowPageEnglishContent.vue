<template>
    <div>
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Page English Content</p>
            <div class="flex justify-end">
                <router-link
                    :to="`/pages/${$route.params.page}/manage/content/edit/en`"
                    class="btn btn-dark"
                    >Edit</router-link
                >
            </div>
        </div>
        <div class="my-12">
            <div v-html="page.content_html.en"></div>
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["page"],
};
</script>
