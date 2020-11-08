<template>
    <page>
        <page-header title="XTERRA Discover Pages">
            <router-link to="/pages/create" class="btn btn-dark"
                >New Page</router-link
            >
        </page-header>

        <div class="my-12">
            <language-selector v-model="lang"></language-selector>
        </div>

        <div class="my-12">
            <div
                v-for="page in pages"
                :key="page.id"
                class="max-w-xl shadow mb-8 p-6 rounded-lg"
            >
                <p class="text-xl font-bold mb-4">
                    <router-link
                        :to="`/pages/${page.id}/manage`"
                        class="hover:text-blue-700"
                        >{{ page.title[lang] }}</router-link
                    >
                </p>
                <colour-label
                    :colour="page.is_public ? 'green' : 'orange'"
                    :text="page.is_public ? 'live' : 'draft'"
                ></colour-label>
                <p class="my-4">{{ page.description[lang] }}</p>
            </div>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import LanguageSelector from "../LanguageSelector";
import ColourLabel from "../ColourLabel";

export default {
    components: {
        ColourLabel,
        LanguageSelector,
        Page,
        PageHeader,
    },

    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        pages() {
            return this.$store.state.pages.all;
        },
    },

    mounted() {
        this.$store.dispatch("pages/fetch");
    },
};
</script>
