<template>
    <div>
        <div class="flex justify-between mb-12">
            <p class="font-bold text-lg">Campaign Content</p>
            <div class="flex justify-end">
                <router-link
                    :to="`/campaigns/${$route.params.campaign}/show/content/edit/${lang}`"
                    class="btn btn-dark"
                    >Edit</router-link
                >
            </div>
        </div>

        <div class="my-12">
            <language-selector v-model="lang"></language-selector>
        </div>

        <div class="my-12 max-w-3xl">
            <div v-html="campaign.narrative_html[lang]"></div>
        </div>
    </div>
</template>

<script type="text/babel">
import LanguageSelector from "../LanguageSelector";
export default {
    components: { LanguageSelector },

    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        campaign() {
            return this.$store.getters["campaigns/byId"](
                this.$route.params.campaign
            );
        },
    },
};
</script>
