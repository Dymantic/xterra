<template>
    <form class="max-w-4xl mx-auto shadow-lg bg-white p-8"
          @submit.prevent="submit">
        <div class="flex justify-between">
            <div class="w-1/2 mr-8">
                <div class="my-4"
                     :class="{'border-b border-red-400': formErrors['title.en']}">
                    <label class="form-label"
                           for="title.en">English Title</label>
                    <span class="text-xs text-red-400"
                          v-show="formErrors['title.en']">{{ formErrors['title.en'] }}</span>
                    <input type="text"
                           name="title.en"
                           v-model="formData.title.en"
                           class="form-input"
                           id="title.en">
                </div>
                <div class="my-4"
                     :class="{'border-b border-red-400': formErrors['description.en']}">
                    <label class="form-label"
                           for="description.en">English Description</label>
                    <span class="text-xs text-red-400"
                          v-show="formErrors['description.en']">{{ formErrors['description.en'] }}</span>
                    <textarea name="description.en"
                              v-model="formData.description.en"
                              class="form-input h-32"
                              id="description.en"></textarea>
                </div>
            </div>
            <div class="w-1/2 ml-8">
                <div class="my-4"
                     :class="{'border-b border-red-400': formErrors['title.zh']}">
                    <label class="form-label"
                           for="title.zh">Chinese Title</label>
                    <span class="text-xs text-red-400"
                          v-show="formErrors['title.zh']">{{ formErrors['title.zh'] }}</span>
                    <input type="text"
                           name="title.zh"
                           v-model="formData.title.zh"
                           class="form-input"
                           id="title.zh">
                </div>
                <div class="my-4"
                     :class="{'border-b border-red-400': formErrors['description.zh']}">
                    <label class="form-label"
                           for="description.zh">Chinese Description</label>
                    <span class="text-xs text-red-400"
                          v-show="formErrors['description.zh']">{{ formErrors['description.zh'] }}</span>
                    <textarea name="description.zh"
                              v-model="formData.description.zh"
                              class="form-input h-32"
                              id="description.zh"></textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end my-4">
            <button type="submit"
                    :disabled="waiting"
                    class="btn btn-dark">{{ submit_text }}
            </button>
        </div>
    </form>
</template>

<script type="text/babel">
    import {notify} from "../Messaging/notify";

    export default {

        props: ['category-id', 'initial-data'],

        data() {
            return {
                waiting: false,
                formData: {
                    title: {
                        en: '',
                        zh: '',
                    },
                    description: {
                        en: '',
                        zh: '',
                    }
                },
                formErrors: {
                    'title.en': '',
                    'description.en': '',
                    'title.zh': '',
                    'description.zh': '',
                }
            };
        },

        computed: {
            submit_text() {
                return this.categoryId ? 'Save changes' : 'Add Category';
            }
        },

        mounted() {
            if (this.initialData) {
                this.formData.title.en = this.initialData.title.en;
                this.formData.title.zh = this.initialData.title.zh;
                this.formData.description.en = this.initialData.description.en;
                this.formData.description.zh = this.initialData.description.zh;
            }
        },

        methods: {
            submit() {


                if (this.categoryId) {
                    return this.persist({
                        action: 'articles/updateCategory',
                        payload: {id: this.categoryId, formData: this.formData},
                        exit_route: `/categories/${this.categoryId}`,
                        error_message: 'Unable to update category',
                    });
                }

                return this.persist({
                    action: 'articles/addCategory',
                    payload: this.formData,
                    exit_route: `/categories`,
                    error_message: 'Unable to add category',
                });

            },

            persist({action, payload, exit_route, error_message}) {
                this.waiting = true;
                this.clearFormErrors();
                this.$store.dispatch(action, payload)
                    .then((message) => {
                        notify.success(message);
                        this.$router.push(exit_route);
                    })
                    .catch(({status, data}) => {
                        if (status === 422) {
                            return this.setFormErrors(data.errors);
                        }
                        notify.error({message: error_message});
                    })
                    .then(() => this.waiting = false);
            },

            setFormErrors(errors) {
                Object.keys(errors).forEach(key => {
                    if (this.formErrors.hasOwnProperty(key)) {
                        this.formErrors[key] = errors[key][0];
                    }
                });
            },

            clearFormErrors() {
                this.formErrors = {
                    'title.en': '',
                    'description.en': '',
                    'title.zh': '',
                    'description.zh': '',
                };
            }
        }
    }
</script>