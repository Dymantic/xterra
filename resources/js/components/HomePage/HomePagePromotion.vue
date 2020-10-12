<template>
    <div>
        <div class="flex justify-between mb-12">
            <p class="font-bold text-lg">Homepage Promotion</p>
            <div class="flex justify-end">
                <promotion-selector
                    @promo-selected="setPromotion"
                ></promotion-selector>
            </div>
        </div>

        <div class="my-12">
            <language-selector v-model="lang"></language-selector>
        </div>

        <div v-if="homePage.promotion">
            <div
                class="flex justify-between max-w-xl p-6 rounded-lg shadow-lg bg-white"
            >
                <div class="w-1/2">
                    <img :src="homePage.promotion.image.web" class="" alt="" />
                </div>
                <div class="w-1/2 px-8">
                    <p class="font-bold mb-1">
                        <router-link
                            :to="`/promotions/${homePage.promotion.id}/show`"
                            >{{ homePage.promotion.title[lang] }}</router-link
                        >
                    </p>
                    <p class="my-4 text-sm">
                        {{ homePage.promotion.writeup[lang] }}
                    </p>
                    <div class="text-center">
                        <span
                            class="text-xs uppercase px-6 py-2 bg-blue-700 text-white uppercase rounded"
                            >{{ homePage.promotion.button_text[lang] }}</span
                        >
                        <p class="mt-2 text-xs text-gray-600">
                            {{ homePage.promotion.link }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import { notify } from "../Messaging/notify";
import PromotionSelector from "../Promotions/PromotionSelector";
import LanguageSelector from "../LanguageSelector";

export default {
    components: { LanguageSelector, PromotionSelector },
    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        homePage() {
            return this.$store.state.homepage.homepage;
        },
    },

    methods: {
        setPromotion({ id }) {
            this.$store
                .dispatch("homepage/attachPromotion", id)
                .catch(() =>
                    notify.error({ message: "Failed to attach event" })
                );
        },
    },
};
</script>
