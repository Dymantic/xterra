<template>
    <span>
        <button class="btn-sm btn-link"
                @click="showModal = true">Add {{ language.name }} version</button>
        <modal :show="showModal">
            <form @submit.prevent="submit" class="amx-w-xl p-8">
                <p class="text-lg font-bold mb-6">Add a {{ language.name }} translation for this article.</p>


                <div class="my-4"
                     :class="{'border-b border-red-400': formErrors.title}">
                    <label class="form-label"
                           for="title">{{ language.name }} Title</label>
                    <span class="text-xs text-red-400"
                          v-show="formErrors.title">{{ formErrors.title }}</span>
                    <input type="text"
                           name="title"
                           v-model="formData.title"
                           class="form-input"
                           id="title">
                </div>
                <div class="flex justify-end mt-6">
                    <button type="button" @click="showModal = false" class="text-gray-600 mr-6">Cancel</button>
                    <button :disabled="waiting" type="submit" class="btn btn-dark">Add Translation</button>
                </div>
            </form>
        </modal>
    </span>
</template>

<script type="text/babel">
    import Modal from "@dymantic/modal";
    import {notify} from "../Messaging/notify";

    export default {

        components: {
            Modal,
        },

        props: ['language', 'article-id'],

        data() {
            return {
                waiting: false,
                showModal: false,
                formData: {
                    title: '',
                },
                formErrors: {
                    title: '',
                }
            };
        },

        methods: {
            submit() {
                this.waiting = true;
                this.$store.dispatch('articles/addTranslation', {
                    article_id: this.articleId,
                    lang: this.language.code,
                    title: this.formData.title,
                })
                    .then(({id}) => this.$router.push(`/translations/${id}/edit`))
                    .catch(this.onSubmitError)
                    .then(() => this.waiting = false);
            },

            onSubmitError({status, data}) {
                if (status === 422) {
                    return this.handleValidationError(data)
                }
                notify.error({message: 'Unable to add translation'});
            },

            handleValidationError({errors}) {
                if (errors.title) {
                    return this.formErrors.title = errors.title[0];
                }
                notify.error({message: 'Unable to add translation'});
            }
        }
    }
</script>
