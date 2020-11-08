<template>
    <div>
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Page Meta Information</p>
            <div class="flex justify-end">
                <router-link
                    :to="`/pages/${page.id}/manage/meta/edit`"
                    class="btn-dark btn"
                    >Edit</router-link
                >
            </div>
        </div>

        <div class="my-12">
            <language-selector v-model="lang"></language-selector>
        </div>

        <div class="my-12">
            <div class="mb-6">
                <p class="text-xs font-semibold uppercase">Title</p>
                <p class="mt-1">{{ page.title[lang] }}</p>
            </div>

            <div class="mb-6">
                <p class="text-xs font-semibold uppercase">Tab/browser Title</p>
                <p class="mt-1">XTERRA Taiwan | {{ page.title[lang] }}</p>
            </div>

            <div class="mb-6">
                <p class="text-xs font-semibold uppercase">Menu title</p>
                <p class="mt-1">{{ page.menu_name[lang] }}</p>
            </div>

            <div class="mb-6">
                <p class="text-xs font-semibold uppercase">Link to page</p>
                <p class="mt-1">
                    https://xterrataiwan.com/discover/{{ page.slug }}
                </p>
                <p class="mt-2 text-sm" v-if="page.is_draft">
                    * The URL for this page will continue to update along with
                    the title, until it is first published. It will then be
                    permanent.
                </p>
                <p class="mt-2 text-sm" v-else>
                    * As this page has been public in the past, the URL cannot
                    be updated.
                </p>
            </div>

            <div class="mb-6">
                <p class="text-xs font-semibold uppercase">Description</p>
                <p class="mt-1">{{ page.description[lang] }}</p>
            </div>

            <div class="mb-6">
                <p class="text-xs font-semibold uppercase">Intro</p>
                <p class="mt-1">{{ page.blurb[lang] }}</p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import LanguageSelector from "../LanguageSelector";
export default {
    components: { LanguageSelector },
    props: ["page"],

    data() {
        return {
            lang: "en",
        };
    },
};
</script>
