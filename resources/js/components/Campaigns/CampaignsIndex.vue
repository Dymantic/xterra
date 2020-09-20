<template>
    <page>
        <page-header title="Campaigns">
            <router-link to="/campaigns/create" class="btn btn-dark"
                >New Campaign</router-link
            >
        </page-header>

        <div class="">
            <language-selector v-model="lang"></language-selector>
        </div>
        <div>
            <div
                v-for="campaign in campaigns"
                :key="campaign.id"
                class="my-8 shadow flex justify-between p-6 rounded-lg"
            >
                <div>
                    <p class="text-2xl">
                        <router-link
                            class="hover:text-blue-600"
                            :to="`/campaigns/${campaign.id}/show`"
                            >{{ campaign.title[lang] }}</router-link
                        >
                    </p>
                    <p class="my-4">{{ campaign.intro[lang] }}</p>
                    <p class="my-4 text-gray-600 text-sm">
                        {{ campaign.description[lang] }}
                    </p>
                </div>
                <div class="ml-8 flex flex-col justify-center">
                    <div class="w-64 h-42">
                        <img
                            :src="campaign.title_image.web"
                            alt=""
                            class="w-full h-full object-cover"
                        />
                    </div>
                </div>
            </div>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import LanguageSelector from "../LanguageSelector";
export default {
    components: {
        Page,
        PageHeader,
        LanguageSelector,
    },

    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        campaigns() {
            return this.$store.state.campaigns.all;
        },
    },

    mounted() {
        this.$store.dispatch("campaigns/fetchAll");
    },
};
</script>
