<template>
    <div class="my-6 pb-6 border-b">
        <div class="flex">
            <p class="text-sm text-gray-700">{{ comment.author }}</p>
            <p class="text-sm text-gray-700 ml-8">{{ comment.time_ago }}</p>
        </div>
        <div v-html="comment.body"></div>
        <div class="flex justify-end">
            <button class="" @click="showReplyBox">
                <svg class="text-grey-500 hover:text-red-500 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M19 16.685S16.775 6.953 8 6.953V2.969L1 9.542l7 6.69v-4.357c4.763-.001 8.516.421 11 4.81z"/></svg>
            </button>
        </div>
        <div v-show="quill">
            <div :id="`toolbar_${comment.id}`">
                <button class="ql-bold">Bold</button>
                <button class="ql-italic">Italic</button>
                <button class="ql-link">Link</button>
            </div>
            <div ref="quill_box" :id="`comment_${comment.id}`"></div>
            <div class="flex justify-end mt-2" v-if="hasCredentials">
                <button @click="destroyReplyBox" class="text-grey-500 hover:text-red-700 text-sm mr-4">Cancel</button>
                <button @click="postReply" class="text-white bg-red-500 hover:bg-red-700 text-sm p-1 font-bold">Send Reply</button>
            </div>
        </div>
        <div>
            <div v-for="reply in comment.replies" :key="reply.id" class="pl-8 mb-6">
                <div class="flex">
                    <p class="text-sm text-gray-700">{{ reply.author }}</p>
                    <p class="text-sm text-gray-700 ml-8">{{ reply.time_ago }}</p>
                </div>
                <div v-html="reply.body"></div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">

    import Quill from "quill";
    import axios from "axios";

    export default {
        props: ['comment', 'author', 'fb_id'],

        data() {
            return {
                quill: null,
            };
        },

        computed: {
            hasCredentials() {
                return (!!this.author) && (!!this.fb_id);
            }
        },

        methods: {
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
                axios.post(`/comments/${this.comment.id}/replies`, {
                    author: this.author,
                    fb_id: this.fb_id,
                    body: this.quill.root.innerHTML,
                })
                    .then(() => {
                        this.$emit('reply-posted');
                        this.destroyReplyBox();
                    })
                    .catch(console.log);
            }
        }
    }
</script>
