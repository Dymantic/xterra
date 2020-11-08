<template>
    <fancy-editor
        :back-to="`/pages/${$route.params.page}/manage/content/${$route.params.lang}`"
        :upload-images-to="`/admin/pages/${page.id}/images`"
        @save="saveContent"
        :saving="waiting"
        :initial-data="page.content_raw[$route.params.lang]"
        editor-title="English Content"
    ></fancy-editor>
</template>

<script type="text/babel">
import FancyEditor from "../FancyEditor";
import { notify } from "../Messaging/notify";
export default {
    components: { FancyEditor },

    data() {
        return {
            waiting: false,
        };
    },

    props: ["page"],

    methods: {
        saveContent(content) {
            this.$store
                .dispatch("pages/updateContent", {
                    page_id: this.page.id,
                    content: content,
                    lang: this.$route.params.lang,
                })
                .then(() => notify.success({ message: "Content saved." }))
                .catch(() =>
                    notify.error({ message: "Failed to save content " })
                );
        },
    },
};
</script>
