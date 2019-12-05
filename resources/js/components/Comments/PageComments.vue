<template>
    <div class="max-w-2xl mx-auto mt-8 p-8">
        <div :class="{'opacity-50': !ready}"
             @click="init">
            <p v-if="post_error" class="text-red-500 my-6">{{ trans('comments.error') }}</p>
            <span class="text-sm uppercase font-light text-gray-600 block mb-1">{{ name }}</span>
            <div id="toolbar">
                <button class="ql-bold">Bold</button>
                <button class="ql-italic">Italic</button>
                <button class="ql-link">Link</button>
            </div>

            <div id="comment-box"
                 placeholder="leave your comment here"
                 class="w-full border p-2"></div>
            <div class="flex justify-end">
                <button @click="postComment"
                        class="bg-red-700 mt-4 py-1 px-2 text-white type-b4">{{ trans("comments.button_post") }}</button>
            </div>
        </div>
        <div class="comments-content">
            <comment v-for="comment in comments"
                     :key="comment.id"
                     :comment="comment"
                     :fb_id="fb_id"
                     :author="name"
                     @requires-authentication="getCredentials"
                     @reply-posted="fetchComments"
                     @flag-comment="flagComment"
                     @flag-reply="flagReply"
            >
            </comment>
        </div>
        <modal :show="showFlagForm" @close="clearFlagging">
            <div class="p-8 max-w-md">
                <div v-if="flagging.is_flagged">
                    <p class="my-6">{{ trans('flagging.done') }}</p>
                    <div class="flex justify-end mt-6">
                        <button @click="clearFlagging"
                                class="bg-grey-700 py-1 px-2 text-white hover:bg-grey-500">{{ trans('flagging.button_okay') }}</button>
                    </div>
                </div>
                <div v-else>
                    <p class="text-lg font-bold mb-6">{{ trans('flagging.title') }} {{ flagging.comment_author }}</p>
                    <p v-if="flagging_failed" class="mb-6 text-red-700 font-bold text-lg">{{ trans('flagging.error')}}</p>

                    <form @submit.prevent="submitFlag">
                        <div class="max-h-48 overflow-auto">
                            <div class="bg-grey-200 p-2 h-12 lg:h-24 overflow-auto" v-html="flagging.body"></div>
                            <p class="my-6">{{ trans('flagging.instruction') }}</p>
                            <div class="my-4" :class="{'border-b border-red-400': formErrors.reason}">
                                <label class="font-bold" for="reason">{{ trans('flagging.label') }}</label>
                                <span class="text-xs text-red-400" v-show="formErrors.reason">{{ formErrors.reason }}</span>
                                <input autocomplete="off" type="text" name="reason" v-model="flagging.reason"
                                       class="border w-full pl-1" id="reason">
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="button"
                                    @click="clearFlagging"
                                    class="bg-white text-grey-500 mr-4 hover:text-black">{{ trans('flagging.button_cancel') }}
                            </button>
                            <button type="submit" :disabled="awaiting_flag || (flagging.reason === '')"
                                    class="bg-grey-700 py-1 px-2 text-white hover:bg-grey-500">{{ trans('flagging.button_confirm') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    import axios from "axios";
    import Quill from "quill";
    import Comment from "./Comment";
    import Modal from "@dymantic/modal";
    import {trans} from "./translations";

    export default {

        components: {
            Comment,
            Modal,
        },

        props: ['translation-id', 'lang'],

        data() {
            return {
                comments: [],
                comment_text: '',
                ready: false,
                name: trans('comments.default_name', this.lang),
                fb_id: '',
                quill: null,
                post_error: false,
                showFlagForm: false,
                flagging: {
                    flaggable_id: null,
                    is_flagged: false,
                    comment_author: '',
                    body: '',
                    reason: ''
                },
                formErrors: {
                    reason: '',
                },
                awaiting_flag: false,
                flagging_failed: false,
            };
        },

        computed: {
          safe_lang() {
              return ['en', 'zh'].includes(this.lang) ? this.lang : 'en';
          }
        },

        mounted() {
            this.fetchComments();

            this.quill = new Quill('#comment-box', {
                modules: {
                    toolbar: {
                        container: '#toolbar',
                        handlers: {
                            image: () => alert('image')
                        }
                    }
                },
                theme: 'snow'
            });
        },

        methods: {

            trans(path) {
              return trans(path, this.safe_lang);
            },

            init() {
                if (this.ready) {
                    return;
                }

                this.checkSession()
                    .then(({name, id}) => {
                        this.name = name;
                        this.fb_id = id;
                        this.ready = true;
                    })
                    .catch(this.getCredentials);

            },

            getCredentials() {
                FB.login(response => {
                    if (response.authResponse) {
                        sessionStorage.setItem('fb_auth', response.authResponse.accessToken);
                        FB.api("/me", ({name, id}) => {
                            this.name = name;
                            this.fb_id = id;
                            this.ready = true;

                        })
                    }
                })
            },

            checkSession() {
                return new Promise((resolve, reject) => {
                    const token = sessionStorage.getItem('fb_auth');
                    if (!token) {
                        reject();
                        return;
                    }
                    FB.api("/me?access_token=", "get", {access_token: token}, ({name, id}) => {
                        if (!name || !id) {
                            return reject();
                        }
                        resolve({name, id});
                    });
                });
            },


            fetchComments() {
                axios.get(`/translations/${this.translationId}/comments`)
                     .then(({data}) => this.comments = data)
                     .catch(console.log);
            },

            postComment() {
                if (!this.ready) {
                    return;
                }

                this.post_error = false;

                axios.post(`/translations/${this.translationId}/comments`, {
                    author: this.name,
                    fb_id: this.fb_id,
                    body: this.quill.root.innerHTML,
                })
                     .then(({data}) => this.onPosted(data))
                     .catch(() => this.post_error = true);
            },

            onPosted(comments) {
                this.comments = comments;
                this.quill.root.innerHTML = '';
            },

            flagComment({id, body, author, is_flagged = false}) {
                this.flagging.type = 'comments';
                this.flagging.flaggable_id = id;
                this.flagging.comment_author = author;
                this.flagging.body = body;
                this.flagging.is_flagged = is_flagged;
                this.showFlagForm = true;
            },

            flagReply({id, body, author, is_flagged = false}) {
                this.flagging.type = 'replies';
                this.flagging.flaggable_id = id;
                this.flagging.comment_author = author;
                this.flagging.body = body;
                this.flagging.is_flagged = is_flagged;
                this.showFlagForm = true;
            },

            clearFlagging() {
                this.flagging = {
                    flaggable_id: null,
                    comment_author: '',
                    body: '',
                    reason: '',
                    is_flagged: false,
                };
                this.flagging_failed = false;
                this.showFlagForm = false;
            },

            submitFlag() {
                this.formErrors.reason = '';
                this.flagging_failed = false;
                this.awaiting_flag = true;
                axios.post(`/flagged-${this.flagging.type}`, {
                    flaggable_id: this.flagging.flaggable_id,
                    reason: this.flagging.reason,
                })
                     .then(this.clearFlagging)
                     .catch(({response}) => this.flaggingError(response))
                     .then(() => this.awaiting_flag = false)
                     .then(this.fetchComments);
            },

            flaggingError({status, data}) {
                if (status === 422 && (data.errors.reason)) {
                    return this.formErrors.reason = data.errors.reason[0];
                }

                this.flagging_failed = true;
            }
        }
    }
</script>
