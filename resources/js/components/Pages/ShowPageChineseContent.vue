<template>
    <div>
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Page Chinese Content</p>
            <div class="flex justify-end">
                <router-link
                    :to="`/pages/${$route.params.page}/manage/content/edit/zh`"
                    class="btn btn-dark"
                    >Edit</router-link
                >
            </div>
        </div>
        <div class="my-12">
            <div v-html="page.content_html.zh"></div>
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["page"],
};
</script>
