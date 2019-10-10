<template>
    <div v-if="ready"
         class="main-container flex justify-between">
        <div class="flex-1 p-8 editor-panel article-content">
            <p class="text-3xl font-bold">{{ formData.title }}</p>
            <wysiwyg v-model="formData.body"
                     :image-upload-path="`/admin/translations/${translation_id}/images`"
                     v-slot:default="{document}"
                     :max-image-file-size="30"
                     class="max-w-3xl mx-auto">
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
                           for="intro">Intro</label>
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
                           for="description">Description</label>
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
                }
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
            }
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
            this.$store.dispatch('articles/getTranslationById', this.translation_id)
                .then(translation => {
                    this.setForm(translation);
                    this.translation = translation;
                })
                .catch(console.log)
                .then(() => {
                    this.ready = true;
                    window.setInterval(this.updateNow, 1000);
                    window.setInterval(this.saveRoutine, 15000);
                });
        },

        methods: {
            setForm({title, intro, description, body, author_name, tags}) {
                this.formData = {
                    title, intro, description, body, author_name,
                    tags: tags.map(t => t.tag_name),
                };
            },

            save() {
                this.$store.dispatch('articles/saveTranslation', {id: this.translation_id, formData: this.formData})
                    .then(() => this.is_dirty = false)
                    .catch(console.log)
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
