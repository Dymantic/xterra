<template>
    <div>
        <label for="translation_tag_input"
               class="form-label">Tags</label>
        <input @keyup.enter.prevent="addTags"
               type="text"
               v-model="new_tag"
               id="translation_tag_input"
               class="form-input">
        <div class="my-4 flex flex-wrap">
            <div class="text-white text-xs p-1 bg-gray-800 rounded my-2 mr-4"
                 v-for="tag in tags"
                 :key="tag">
                {{ tag }}
                <button class="bg-gray-800 text-white hover:text-red-500 font-bold ml-2 border-l border-gray-200 pl-2 pr-1" @click="removeTag(tag)">
                    &times;
                </button>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['value'],

        data() {
            return {
                tags: [],
                new_tag: '',
            };
        },

        mounted() {
            this.tags = this.value || [];
        },

        methods: {
            addTags() {
                const new_tags = this.new_tag
                                     .split(',')
                                     .map(t => t.trim().toLowerCase())
                                     .filter(t => !this.tags.includes(t));
                this.tags = [...this.tags, ...new_tags];
                this.$emit('input', this.tags);
                this.new_tag = '';
            },

            removeTag(tag) {
                this.tags = this.tags.filter(t => t !== tag);
                this.$emit('input', this.tags);
            }
        }
    }
</script>
