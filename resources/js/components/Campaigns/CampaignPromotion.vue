<template>
    <div>
        <div class="flex justify-between mb-12">
            <p class="font-bold text-lg">Campaign Promotion</p>
            <div class="flex justify-end">
                <promotion-selector
                    @promo-selected="setPromotion"
                ></promotion-selector>
            </div>
        </div>

        <div class="my-12">
            <language-selector v-model="lang"></language-selector>
        </div>

        <div class="my-12">
            <div v-if="!campaign.promotion">
                <p class="my-4 text-gray-600">
                    No promotion has been assigned to this campaign
                </p>
            </div>
            <div v-else>
                <div
                    class="flex justify-between max-w-xl p-6 rounded-lg shadow-lg bg-white"
                >
                    <div class="w-1/2">
                        <img
                            :src="campaign.promotion.image.web"
                            class=""
                            alt=""
                        />
                    </div>
                    <div class="w-1/2 px-8">
                        <p class="font-bold mb-1">
                            <router-link
                                :to="`/promotions/${campaign.promotion.id}/show`"
                                >{{
                                    campaign.promotion.title[lang]
                                }}</router-link
                            >
                        </p>
                        <p class="my-4 text-sm">
                            {{ campaign.promotion.writeup[lang] }}
                        </p>
                        <div class="text-center">
                            <span
                                class="text-xs uppercase px-6 py-2 bg-blue-700 text-white uppercase rounded"
                                >{{
                                    campaign.promotion.button_text[lang]
                                }}</span
                            >
                            <p class="mt-2 text-xs text-gray-600">
                                {{ campaign.promotion.link }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import PromotionSelector from "../Promotions/PromotionSelector";
import { notify } from "../Messaging/notify";
import LanguageSelector from "../LanguageSelector";
export default {
    components: { LanguageSelector, PromotionSelector },

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

    methods: {
        setPromotion({ id }) {
            this.$store
                .dispatch("campaigns/setPromotion", {
                    campaign_id: this.campaign.id,
                    promotion_id: id,
                })
                .then(() => notify.success({ message: "Promotion updated." }))
                .catch(() =>
                    notify.error({ message: "Failed to set promotion" })
                );
        },
    },
};
</script>
