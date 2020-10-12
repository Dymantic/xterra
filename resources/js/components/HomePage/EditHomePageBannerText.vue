<template>
    <div v-if="homePage">
        <div class="flex justify-between mb-12">
            <p class="font-bold text-lg">Edit Banner Text</p>
            <div class="flex justify-end"></div>
        </div>

        <banner-text-form
            :banner-text="homePage.banner_text"
        ></banner-text-form>
    </div>
</template>

<script type="text/babel">
import BannerTextForm from "./BannerTextForm";
export default {
    components: { BannerTextForm },
    computed: {
        homePage() {
            return this.$store.state.homepage.homepage;
        },
    },
};
</script>
