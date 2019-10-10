<template>
    <div class="max-w-2xl mx-auto mb-20">
        <div class="flex justify-center mb-8">
            <button @click="showAll = false"
                    :class="{'text-grey-500': showAll, 'text-black underline': !showAll}"
                    class="focus:outline-none hover:text-red-500 type-b4 mx-4">Popular Tags
            </button>
            <button @click="showAll = true"
                    :class="{'text-grey-500': !showAll, 'text-black underline': showAll}"
                    class="focus:outline-none hover:text-red-500 type-b4 mx-4">All Tags
            </button>
        </div>
        <div class="h-80 overflow-scroll">
            <div class="flex flex-wrap justify-around">
                <a v-for="tag in show_tags"
                   :key="tag.id"
                   class="block w-40 sm:w-48 type-b6 hover:text-red-500 my-3 text-center uppercase"
                   :href="`/en/tags/${tag.slug}`">{{ tag.tag_name }}</a>
            </div>
        </div>

    </div>
</template>

<script type="text/babel">
    export default {
        props: ['tags'],

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
            }
        }
    }
</script>