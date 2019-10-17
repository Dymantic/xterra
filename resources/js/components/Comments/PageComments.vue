<template>
    <div class="max-w-2xl mx-auto mt-8 p-8">
        <div :class="{'opacity-50': !ready}"
             @click="init">
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
                        class="bg-red-500 mt-4 py-2 px-4 text-white type-b4">Post it
                </button>
            </div>
        </div>
        <div>
            <comment v-for="comment in comments"
                     :key="comment.id"
                     :comment="comment"
                     :fb_id="fb_id"
                     :author="name"
                     @requires-authentication="getCredentials"
                     @reply-posted="fetchComments"
            >
            </comment>
        </div>
    </div>
</template>

<script type="text/babel">
    import axios from "axios";
    import Quill from "quill";
    import Comment from "./Comment";

    export default {

        components: {
            Comment,
        },

        props: ['translation-id'],

        data() {
            return {
                comments: [],
                comment_text: '',
                ready: false,
                name: 'Anonymous',
                fb_id: '',
                quill: null,
            };
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
                   if(!token) {
                       reject();
                       return;
                   }
                   FB.api("/me?access_token=", "get", {access_token: token}, ({name, id}) => {
                        if(!name || !id) {
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

                axios.post(`/translations/${this.translationId}/comments`, {
                    author: this.name,
                    fb_id: this.fb_id,
                    body: this.quill.root.innerHTML,
                })
                     .then(({data}) => this.onPosted(data))
                     .catch(console.log);
            },

            onPosted(comments) {
                this.comments = comments;
                this.quill.root.innerHTML = '';
            }
        }
    }
</script>
