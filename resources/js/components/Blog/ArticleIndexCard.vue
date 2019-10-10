<template>
    <div class="m-4 bg-white max-w-4xl mx-auto">
        <div v-show="showTranslation(trans)" v-for="(trans, index) in article.translations" :key="trans.id" class="py-2 px-4 flex items-center justify-between py-2" :class="{'border-t border-gray-200': index === 1}">
            <div class="flex items-center">
                <p class="text-gray-600 uppercase tracking-wide font-bold pr-4">{{ trans.language }}</p>
                <p class="w-120 flex-1 truncate">{{ trans.title }}</p>
                <div class="w-24 text-center">
                    <translation-status :translation="trans"></translation-status>
                </div>
                <div class="text-sm text-gray-600 w-24 text-center">{{ trans.publish_date }}</div>
            </div>
            <div>
                <p class="text-sm text-gray-600">{{ trans.author_name }}</p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import TranslationStatus from "./TranslationStatus";

    function contains(haystack, needle) {
        return haystack.toLowerCase().includes(needle.toLowerCase());
    }
    export default {

        components: {
            TranslationStatus,
        },

        props: ['article', 'filters'],

        methods: {
            showTranslation(translation) {
                if(this.filters.title !== "") {
                    if(!contains(translation.title, this.filters.title)) {
                        return false;
                    }
                }

                if(this.filters.author !== "") {
                    if(!contains(translation.author_name, this.filters.author)) {
                        return false;
                    }
                }

                if(!this.filters.status.live && translation.is_live) {
                    return false;
                }

                if(!this.filters.status.draft && (!translation.is_published)) {
                    return false;
                }

                if(!this.filters.status.scheduled && (!translation.is_live && translation.is_published)) {
                    return false;
                }
                return true;
            }
        }
    }
</script>