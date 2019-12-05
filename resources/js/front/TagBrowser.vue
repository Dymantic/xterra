<template>
    <div class="max-w-2xl mx-auto mb-20">
        <div class="flex justify-center mb-8">
            <button @click="showAll = false"
                    :class="{'text-grey-500': showAll, 'text-black underline': !showAll}"
                    class="focus:outline-none hover:text-red-500 type-b4 mx-4">{{ popular_tags_title }}</button>
            <button @click="showAll = true"
                    :class="{'text-grey-500': !showAll, 'text-black underline': showAll}"
                    class="focus:outline-none hover:text-red-500 type-b4 mx-4">{{ all_tags_title }}</button>
        </div>
        <div class="h-80 overflow-scroll">
            <div class="flex flex-wrap justify-around">
                <a v-for="tag in show_tags"
                   :key="tag.id"
                   class="block w-40 sm:w-48 type-b6 hover:text-red-500 my-3 text-center uppercase"
                   :href="`/${safe_lang}/tags/${tag.id}/${tag.slug}`">{{ tag.tag_name }}</a>
            </div>
        </div>

    </div>
</template>

<script type="text/babel">
    export default {
        props: ['tags', 'lang'],

        data() {
            return {
                showAll: false,
            };
        },

        computed: {
            show_tags() {
                if (this.showAll) {
                    return this.tags.sort((a, b) => {
                        const nameA = a.tag_name.toUpperCase();
                        const nameB = b.tag_name.toUpperCase();

                        if(nameA > nameB) {
                            return 1;
                        }

                        if(nameB > nameA) {
                            return -1;
                        }
                        return 0;
                    });
                }

                return this.tags.sort((a, b) => b.translations_count - a.translations_count).slice(0, 12);
            },

            safe_lang() {
                return ['en', 'zh'].includes(this.lang) ? this.lang : 'en';
            },

            all_tags_title() {
                const trans = {
                    en: 'All Tags',
                    zh: '所有標籤'
                };

                return trans[this.safe_lang];
            },

            popular_tags_title() {
                const trans = {
                    en: 'Popular Tags',
                    zh: '熱門標籤'
                };

                return trans[this.safe_lang];
            }
        }
    }
</script>
