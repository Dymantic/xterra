<template>
    <div>
        <div class="flex justify-between mb-12">
            <p class="font-bold text-lg">Homepage Campaign</p>
            <div class="flex justify-end">
                <campaign-selector
                    @campaign-selected="setCampaign"
                ></campaign-selector>
            </div>
        </div>

        <div class="my-12">
            <language-selector v-model="lang"></language-selector>
        </div>

        <div class="my-12">
            <div
                v-if="homePage.campaign"
                class="my-8 shadow flex justify-between p-6 rounded-lg"
            >
                <div>
                    <p class="text-2xl">
                        <router-link
                            class="hover:text-blue-600"
                            :to="`/campaigns/${homePage.campaign.id}/show`"
                            >{{ homePage.campaign.title[lang] }}</router-link
                        >
                    </p>
                    <p class="my-4">{{ homePage.campaign.intro[lang] }}</p>
                    <p class="my-4 text-gray-600 text-sm">
                        {{ homePage.campaign.description[lang] }}
                    </p>
                </div>
                <div class="ml-8 flex flex-col justify-center">
                    <div class="w-64 h-42">
                        <img
                            :src="homePage.campaign.title_image.web"
                            alt=""
                            class="w-full h-full object-cover"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import CampaignSelector from "../Campaigns/CampaignSelector";
import { notify } from "../Messaging/notify";
import LanguageSelector from "../LanguageSelector";
export default {
    components: { LanguageSelector, CampaignSelector },

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
        setCampaign({ id }) {
            this.$store
                .dispatch("homepage/attachCampaign", id)
                .catch(() =>
                    notify.error({ message: "Failed to attach event" })
                );
        },
    },
};
</script>
