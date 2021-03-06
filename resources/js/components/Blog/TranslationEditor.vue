<template>
    <div v-if="ready"
         class="main-container flex justify-between">
        <div class="flex-1 px-8 pb-8 editor-panel article-content flex flex-col">
            <p class="text-3xl mt-6 font-bold">{{ formData.title }}</p>
            <wysiwyg v-model="formData.body"
                     :image-upload-path="`/admin/translations/${translation_id}/images`"
                     v-slot:default="{document}"
                     :max-image-file-size="30"
                     :sticky="true"
                     class="max-w-3xl mx-auto flex-1">
                <video-embed :trix="document"></video-embed>
                <insert-highlight :trix="document"></insert-highlight>

            </wysiwyg>
        </div>
        <div class="w-120 bg-gray-300">
            <div class="p-4">
                <div class="my-4"
                     :class="{'border-b border-red-400': formErrors.title}">
                    <label class="form-label text-gray-800"
                           for="title">Title</label>
                    <span class="text-xs text-red-400"
                          v-show="formErrors.title">{{ formErrors.title }}</span>
                    <input type="text"
                           name="title"
                           v-model="formData.title"
                           class="form-input"
                           id="title">
                </div>
                <div class="my-4"
                     :class="{'border-b border-red-400': formErrors.author_name}">
                    <label class="form-label text-gray-800"
                           for="author_name">Author</label>
                    <span class="text-xs text-red-400"
                          v-show="formErrors.author_name">{{ formErrors.author_name }}</span>
                    <input type="text"
                           name="author_name"
                           v-model="formData.author_name"
                           class="form-input"
                           id="author_name">
                </div>
                <div class="my-4"
                     :class="{'border-b border-red-400': formErrors.intro}">
                    <label class="form-label text-gray-800"
                           for="intro">Introduction</label>
                    <span class="text-xs text-red-400"
                          v-show="formErrors.intro">{{ formErrors.intro }}</span>
                    <textarea name="intro"
                              v-model="formData.intro"
                              class="form-input h-24"
                              id="intro"></textarea>
                </div>
                <div class="my-4"
                     :class="{'border-b border-red-400': formErrors.description}">
                    <label class="form-label text-gray-800"
                           for="description">Description (for seo)</label>
                    <span class="text-xs text-red-400"
                          v-show="formErrors.description">{{ formErrors.description }}</span>
                    <textarea name="description"
                              v-model="formData.description"
                              class="form-input h-24"
                              id="description"></textarea>
                </div>
                <translation-tagger v-model="formData.tags"></translation-tagger>
            </div>

        </div>
        <div class="absolute bottom-0 w-full h-16 flex justify-between px-4 bg-white shadow-top">
            <div class="flex items-center">
                <a class="btn btn-link mr-4" :href="`/public-preview/${translation.article_preview_key}/${translation.id}`"
                   target="_blank">Preview</a>
                <publish-button :is-published="translation.is_published"
                                :translation-id="translation_id"
                                @translation-updated="updateTranslation"
                                class="mr-4"
                ></publish-button>
                <translation-status :translation="translation"
                                    :show-date="true"
                ></translation-status>
            </div>
            <div class="flex justify-end items-center">
                <p class="text-sm mr-4">{{ last_saved }}</p>
                <button class="btn"
                        :class="{'btn-dark': is_dirty, 'btn-grey': !is_dirty}"
                        @click="save">Save
                </button>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import Wysiwyg from "@dymantic/vue-trix-editor";
    import PublishButton from "./PublishTranslationButton";
    import TranslationStatus from "./TranslationStatus";
    import TranslationTagger from "./TranslationTagger";
    import VideoEmbed from "./EmbedVideo";
    import InsertHighlight from "./InsertHighlight";
    import {notify} from "../Messaging/notify";

    function timeSince(time, now) {
        if (!time) {
            return '';
        }

        if (now.getTime() - time.getTime() < 60000) {
            return 'less than a minute ago';
        }

        return `at ${time.toTimeString().slice(0, 5)}`;

    }


    export default {

        components: {
            Wysiwyg,
            PublishButton,
            TranslationStatus,
            TranslationTagger,
            VideoEmbed,
            InsertHighlight,
        },

        data() {
            return {
                ready: false,
                formData: null,
                is_dirty: false,
                last_saved_at: null,
                now: new Date(),
                translation: null,
                formErrors: {
                    title: '',
                    intro: '',
                    description: '',
                    author_name: '',
                },
                update_now_interval: null,
                save_routine_interval: null,
            };
        },

        watch: {
            formData: {
                deep: true,
                handler(a, b) {
                    if (!this.ready) {
                        return;
                    }
                    this.is_dirty = true;
                }
            },

            '$route': function () {
                this.ready = false;
                this.is_dirty = false;
                this.shutDownIntervals();
                this.fetchTranslation();
            },
        },

        computed: {
            translation_id() {
                return parseInt(this.$route.params.id);
            },

            translation_tags() {
                if (!this.translation) {
                    return [];
                }

                return this.translation.tags.map(tag => tag.tag_name);
            },

            last_saved() {
                if (!this.last_saved_at) {
                    return '';
                }
                const time = timeSince(this.last_saved_at, this.now);
                return `Last saved ${time}`;
            }
        },

        mounted() {
            this.fetchTranslation();
        },

        methods: {

            fetchTranslation() {
                this.$store.dispatch('articles/getTranslationById', this.translation_id)
                    .then(translation => {
                        this.setForm(translation);
                        this.translation = translation;
                    })
                    .catch(() => notify.error({message: 'Unable to fetch translation data'}))
                    .then(() => {
                        this.ready = true;
                        this.startUpIntervals();
                    });
            },

            setForm({title, intro, description, body, author_name, tags}) {
                this.formData = {
                    title, intro, description, body, author_name,
                    tags: tags.map(t => t.tag_name),
                };
            },

            startUpIntervals() {
                this.update_now_interval = window.setInterval(this.updateNow, 1000);
                this.save_routine_interval = window.setInterval(this.saveRoutine, 15000);
            },

            shutDownIntervals() {
                window.clearInterval(this.update_now_interval);
                window.clearInterval(this.save_routine_interval);

                this.update_now_interval = null;
                this.save_routine_interval = null;
            },

            save() {
                this.$store.dispatch('articles/saveTranslation', {id: this.translation.id, formData: this.formData})
                    .then(() => this.is_dirty = false)
                    .catch(() => notify.error({message: 'There was an issue saving your content'}))
                    .then(() => this.last_saved_at = new Date());
            },

            saveRoutine() {
                if (this.is_dirty) {
                    this.save();
                }
            },

            updateNow() {
                this.now = new Date();
            },

            updateTranslation(translation) {
                this.translation = translation;
            }
        }
    }
</script>

<style scoped
       lang="css">
    .main-container {
        height: calc(100vh - 4rem);
    }

    .editor-panel {
        height: calc(100% - 4rem);
        overflow: auto;
    }


</style>

<style lang="css">
    .main-container iframe {
        pointer-events: none;
    }
</style>
