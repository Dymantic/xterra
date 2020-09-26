<template>
    <div v-if="race">
        <div class="my-12">
            <language-selector v-model="lang"></language-selector>
        </div>
        <div
            class="flex justify-between items-center border-b border-gray-300 pb-3"
        >
            <p class="font-bold text-lg">Race Rules</p>
            <div class="flex justify-end">
                <router-link
                    class="btn btn-dark"
                    :to="`/events/${$route.params.event}/races/${$route.params.race}/edit/rules/${lang}/edit`"
                    >Edit</router-link
                >
            </div>
        </div>
        <div class="mt-8" v-html="race.race_rules_html[lang]"></div>
    </div>
</template>

<script type="text/babel">
import LanguageSelector from "../LanguageSelector";
export default {
    components: {
        LanguageSelector,
    },

    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        race() {
            return this.$store.getters["events/currentEventActivityById"](
                this.$route.params.race
            );
        },
    },
};
</script>
