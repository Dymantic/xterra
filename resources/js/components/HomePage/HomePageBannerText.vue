<template>
    <div v-if="homePage">
        <div class="flex justify-between mb-12">
            <p class="font-bold text-lg">Banner Text</p>
            <div class="flex justify-end">
                <router-link
                    to="/homepage/banner-text/edit"
                    class="btn btn-dark"
                    >Edit</router-link
                >
            </div>
        </div>

        <div class="my-12">
            <language-selector v-model="lang"></language-selector>
        </div>

        <div
            class="my-12 max-w-xl mx-auto rounded-lg bg-red-500 py-24 px-8 shadow"
            :style="background"
        >
            <p
                class="text-5xl font-bold text-white text-center uppercase"
                v-html="homePage.banner_text.heading[lang] || 'no heading set'"
            ></p>
            <p
                class="text-xl text-white text-center mt-6"
                v-html="
                    homePage.banner_text.subheading[lang] || 'no heading set'
                "
            ></p>
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
        homePage() {
            return this.$store.state.homepage.homepage;
        },

        background() {
            return {
                backgroundImage: `url(${this.homePage.banner_image.full})`,
            };
        },
    },
};
</script>
