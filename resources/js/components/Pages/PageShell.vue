<template>
    <page v-if="page">
        <page-header :title="page.title.en" colour="text-indigo-600">
        </page-header>
        <div class="flex">
            <div class="w-64 h-64 pt-6 sticky top-0">
                <div class="mb-2">
                    <router-link
                        :to="`/pages/${$route.params.page}/manage/meta`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Meta Info</router-link
                    >
                </div>

                <div class="mb-2">
                    <router-link
                        :to="`/pages/${$route.params.page}/manage/content/en`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >English Content</router-link
                    >
                </div>

                <div class="mb-2">
                    <router-link
                        :to="`/pages/${$route.params.page}/manage/content/zh`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Chinese Content</router-link
                    >
                </div>

                <div class="mb-2">
                    <router-link
                        :to="`/pages/${$route.params.page}/manage/publish`"
                        class="font-bold hover:text-blue-600"
                        active-class="text-blue-600"
                        >Publish</router-link
                    >
                </div>
            </div>
            <div class="flex-1">
                <router-view :page="page"></router-view>
            </div>
        </div>
    </page>
</template>

<script type="text/babel">
import { notify } from "../Messaging/notify";

export default {
    data() {
        return {};
    },

    computed: {
        page() {
            return this.$store.getters["pages/byId"](this.$route.params.page);
        },
    },

    mounted() {
        this.$store.dispatch("pages/fetch");
    },

    methods: {},
};
</script>
