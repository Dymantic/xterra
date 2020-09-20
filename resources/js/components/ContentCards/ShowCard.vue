<template>
    <page v-if="card">
        <page-header :title="`${card.category[lang]} Card`">
            <router-link class="mx-4 btn" to="/content-cards"
                >&larr; back</router-link
            >
            <router-link
                :to="`/content-cards/${card.id}/edit`"
                class="btn btn-dark"
                >Edit</router-link
            >
        </page-header>

        <div class="my-12">
            <language-selector v-model="lang"></language-selector>
        </div>

        <div>
            <div
                class="flex justify-between max-w-2xl shadow p-6 rounded-lg mx-auto bg-white"
            >
                <div>
                    <span
                        class="px-3 py-1 text-sm bg-red-500 text-white uppercase mb-4"
                    >
                        {{ card.category[lang] }}
                    </span>
                    <p class="uppercase text-2xl my-4">
                        {{ card.title[lang] }}
                    </p>
                    <p class="text-gray-600">
                        <a
                            target="_blank"
                            class="hover:text-blue-600"
                            :href="card.link"
                            >{{ card.link }}</a
                        >
                    </p>
                </div>
                <div>
                    <image-upload
                        :upload-path="`/admin/content-cards/${card.id}/image`"
                        :delete-path="`/admin/content-cards/${card.id}/image`"
                        :initial-src="card.image.web"
                        width="64"
                        height="42"
                        @uploaded="$store.dispatch('cards/refresh')"
                        @invalid-file="handleInvalid"
                        @upload-failed="handleFailure"
                    ></image-upload>
                </div>
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
        ImageUpload,
        LanguageSelector,
    },

    data() {
        return {
            lang: "en",
        };
    },

    computed: {
        card() {
            return this.$store.getters["cards/byId"](this.$route.params.card);
        },
    },

    created() {
        this.$store.dispatch("cards/fetchAll");
    },

    methods: {
        handleInvalid(message) {
            notify.warn({ message });
        },

        handleFailure() {
            notify.error({ message: "Failed to upload image" });
        },
    },
};
</script>
