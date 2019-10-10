<template>
    <span>
        <button @click="showForm = true" class="btn btn-dark">New Article</button>
        <modal :show="showForm" @close="showForm = false">
            <div class="max-w-lg p-8">
                <p class="text-xl mb-6 font-bold">Start a New Article</p>
                <p class="text-sm">Select a language and provide a title to get started. You will be able to edit the title later, and you can always add more translations later as well.</p>
                <p class="form-label mt-4 mb-2">Language</p>
                <div class="flex items-center mb-4">
                    <div class="mr-12">
                        <label for="lang_en">English</label>
                        <input type="radio" value="en" v-model="formData.lang" id="lang_en">
                    </div>
                    <div>
                        <label for="lang_zh">Chinese</label>
                        <input type="radio" value="zh" v-model="formData.lang" id="lang_zh">
                    </div>
                </div>
                <div class="my-4" :class="{'border-b border-red-400': formErrors.title}">
                    <label class="form-label" for="title">Title</label>
                    <span class="text-xs text-red-400" v-show="formErrors.title">{{ formErrors.title }}</span>
                    <input type="text" name="title" v-model="formData.title" class="form-input" id="title">
                </div>
                <div class="flex justify-end mt-6">
                    <button @click="showForm = false">Cancel</button>
                    <button @click="submit" class="btn btn-dark ml-4">Create Article</button>
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    import Modal from "@dymantic/modal";
    import {notify} from "../Messaging/notify";

    export default {
        components: {
            Modal
        },

        data() {
            return {
                showForm: false,
                formData: {
                    lang: 'en',
                    title: '',
                },
                formErrors: {
                    lang: 'en',
                    title: '',
                }
            };
        },

        methods: {
            submit() {
                this.$store.dispatch('articles/createArticle', this.formData)
                    .then(this.onSubmitted)
                    .catch(this.onSubmitError);
            },

            onSubmitted(article) {
                this.$emit('article-created', article.id);
                this.showForm = false;
            },

            onSubmitError({status, data}) {
                if(status === 422) {
                    Object.keys(data.errors).forEach(key => {
                        if(this.formErrors.hasOwnProperty(key)) {
                            this.formErrors[key] = data.errors[key][0];
                        }
                    });

                    return notify.warn({message: 'There is a problem with your input.'});
                }

                this.$emit('create-article-error');
                this.showForm = false;
            }
        }
    }
</script>