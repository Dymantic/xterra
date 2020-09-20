<template>
    <page v-if="promotion">
        <page-header :title="promotion.title.en">
            <router-link
                :to="`/promotions/${promotion.id}/edit`"
                class="btn btn-dark"
                >Edit</router-link
            >
        </page-header>
        <language-selector v-model="lang"></language-selector>
        <div class="max-w-3xl mx-auto p-6 shadow flex justify-between">
            <div>
                <p class="text-xl mb-6 font-bold">
                    {{ promotion.title[lang] }}
                </p>
                <p>{{ promotion.writeup[lang] }}</p>

                <div class="my-6">
                    <a
                        :href="promotion.link"
                        target="_blank"
                        class="shadow rounded-r-full rounded-l-full px-6 py-2 bg-red-500 hover:bg-red-700 text-white"
                        >{{ promotion.button_text[lang] }}</a
                    >
                </div>
            </div>
            <div class="ml-8 pt-8">
                <image-upload
                    :upload-path="`/admin/promotions/${promotion.id}/image`"
                    :delete-path="`/admin/promotions/${promotion.id}/image`"
                    width="64"
                    height="42"
                    :initial-src="promotion.image.original"
                    @uploaded="$store.dispatch('promotions/refresh')"
                    @invalid-file="handleInvalid"
                    @upload-failed="handleFailure"
                ></image-upload>
            </div>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import LanguageSelector from "../LanguageSelector";
import ImageUpload from "../ImageUpload";
import { notify } from "../Messaging/notify";
export default {
    components: {
        Page,
        PageHeader,
        LanguageSelector,
        ImageUpload,
    },

    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        promotion() {
            return this.$store.getters["promotions/byId"](
                this.$route.params.promotion
            );
        },
    },

    created() {
        this.$store.dispatch("promotions/fetchAll");
    },

    methods: {
        handleInvalid(message) {
            notify.warn({ message });
        },

        handleFailure() {
            notify.error({ message: "Unable to upload image" });
        },
    },
};
</script>
