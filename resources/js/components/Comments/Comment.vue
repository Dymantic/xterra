<template>
    <div class="my-6 pb-6 border-b">
        <div class="flex">
            <p class="text-sm text-gray-700">{{ comment.author }}</p>
            <p class="text-sm text-gray-700 ml-8">{{ comment.time_ago }}</p>
        </div>
        <div v-html="comment.body"></div>
        <div class="flex justify-end items-center">
            <button @click="$emit('flag-comment', comment)" class="mr-4">
                <svg :class="{'text-red-500': comment.is_flagged, 'text-grey-500': !comment.is_flagged}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="hover:text-red-500 fill-current h-4"><path d="M4 16v5a1 1 0 0 1-2 0V3a1 1 0 0 1 1-1h8.5a1 1 0 0 1 .7.3l.71.7H21a1 1 0 0 1 .9 1.45L19.11 10l2.77 5.55A1 1 0 0 1 21 17h-8.5a1 1 0 0 1-.7-.3l-.71-.7H4zm7-12H4v10h7.5a1 1 0 0 1 .7.3l.71.7h6.47l-2.27-4.55a1 1 0 0 1 0-.9L19.38 5H13v4a1 1 0 0 1-2 0V4z"/></svg>
            </button>
            <button class="" @click="showReplyBox">
                <svg class="text-grey-500 hover:text-red-500 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M19 16.685S16.775 6.953 8 6.953V2.969L1 9.542l7 6.69v-4.357c4.763-.001 8.516.421 11 4.81z"/></svg>
            </button>
        </div>
        <p v-if="reply_error" class="text-red-500 my-6">{{ trans('comments.reply_error') }}</p>
        <div v-show="quill">
            <div :id="`toolbar_${comment.id}`">
                <button class="ql-bold">Bold</button>
                <button class="ql-italic">Italic</button>
                <button class="ql-link">Link</button>
            </div>
            <div ref="quill_box" :id="`comment_${comment.id}`"></div>
            <div class="flex justify-end mt-2" v-if="hasCredentials">
                <button @click="destroyReplyBox" class="text-grey-500 hover:text-red-700 text-sm mr-4">{{ trans('comments.button_cancel') }}</button>
                <button @click="postReply" class="text-white bg-red-500 hover:bg-red-700 text-sm p-1 font-bold">{{ trans('comments.button_send') }}</button>
            </div>
        </div>
        <div>
            <div v-for="reply in comment.replies" :key="reply.id" class="pl-8 mb-6">
                <div class="flex align-items-center">
                    <p class="text-sm text-gray-700">{{ reply.author }}</p>
                    <p class="text-sm text-gray-700 ml-8">{{ reply.time_ago }}</p>
                    <button @click="$emit('flag-reply', reply)" class="ml-4">
                        <svg :class="{'text-red-500': reply.is_flagged, 'text-grey-500': !reply.is_flagged}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="hover:text-red-500 fill-current h-3"><path d="M4 16v5a1 1 0 0 1-2 0V3a1 1 0 0 1 1-1h8.5a1 1 0 0 1 .7.3l.71.7H21a1 1 0 0 1 .9 1.45L19.11 10l2.77 5.55A1 1 0 0 1 21 17h-8.5a1 1 0 0 1-.7-.3l-.71-.7H4zm7-12H4v10h7.5a1 1 0 0 1 .7.3l.71.7h6.47l-2.27-4.55a1 1 0 0 1 0-.9L19.38 5H13v4a1 1 0 0 1-2 0V4z"/></svg>
                    </button>
                </div>
                <div v-html="reply.body"></div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">

    import Quill from "quill";
    import axios from "axios";
    import {trans} from "./translations";

    export default {
        props: ['comment', 'author', 'fb_id', 'lang'],

        data() {
            return {
                quill: null,
                reply_error: false,
            };
        },

        computed: {
            hasCredentials() {
                return (!!this.author) && (!!this.fb_id);
            },

            safe_lang() {
                return ['en', 'zh'].includes(this.lang) ? this.lang : 'en';
            }
        },

        methods: {

            trans(path) {
                return trans(path, this.safe_lang);
            },

            showReplyBox() {

                if(!this.fb_id) {
                    this.$emit('requires-authentication');
                }

                if(this.quill) {
                    return;
                }

                this.quill = new Quill(`#comment_${this.comment.id}`, {
                    modules: {
                        toolbar: {
                            container: `#toolbar_${this.comment.id}`,
                        }
                    },
                    theme: 'snow'
                });
            },

            destroyReplyBox() {
                this.$refs.quill_box.innerHTML = '';
                this.$refs.quill_box.className = "";
                this.quill = null;
            },

            postReply() {
                this.reply_error = false;

                axios.post(`/comments/${this.comment.id}/replies`, {
                    author: this.author,
                    fb_id: this.fb_id,
                    body: this.quill.root.innerHTML,
                })
                    .then(() => {
                        this.$emit('reply-posted');
                        this.destroyReplyBox();
                    })
                    .catch(() => this.reply_error = true);
            }
        }
    }
</script>
