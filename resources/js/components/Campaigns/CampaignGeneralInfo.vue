<template>
    <div>
        <div class="flex justify-between mb-12">
            <p class="font-bold text-lg">Campaign General Info</p>
            <div class="flex justify-end">
                <router-link
                    class="btn btn-dark"
                    :to="`/campaigns/${$route.params.campaign}/show/edit`"
                    >Edit</router-link
                >
            </div>
        </div>

        <div class="mb-12">
            <language-selector v-model="lang"></language-selector>
        </div>

        <div>
            <p class="text-3xl font-bold">{{ campaign.title[lang] }}</p>
        </div>

        <div class="my-12">
            <p class="text-sm text-gray-600 uppercase mb-2">SEO Description</p>
            <p class="max-w-lg">{{ campaign.description[lang] }}</p>
        </div>

        <div class="my-12">
            <p class="text-sm text-gray-600 uppercase mb-2">Introduction</p>
            <p class="max-w-lg">{{ campaign.intro[lang] }}</p>
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
