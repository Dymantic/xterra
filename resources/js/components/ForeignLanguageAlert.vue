<template>
    <div>
        <modal :show="showModal" @close="showModal = false">
            <div class="max-w-md p-8">
                <p class="text-lg font-bold">{{ trans_title }}</p>
                <p class="my-6">{{ trans_message }}</p>
                <div class="flex justify-end">
                    <button @click="showModal = false" class="bg-white text-grey-700 hover:text-red-700">{{ trans_button }}</button>
                </div>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    import Modal from "@dymantic/modal";

    export default {
        components: {
            Modal,
        },

        props: ['lang'],

        data() {
            return {
                showModal: false,
                title: {
                    en: 'Pardon the interruption',
                    zh: 'Doyba Gi',
                },
                message: {
                    en: 'Unfortunately we do not yet have an English translation for this article yet.',
                    zh: 'Wo men mayo Zhongwen',
                },
                button: {
                    en: 'Okay',
                    zh: 'Mei Guanxi',
                }
            };
        },

        computed: {
            safe_lang() {
                return ['en', 'zh'].includes(this.lang) ? this.lang : 'en';
            },

            trans_title() {
                return this.title[this.safe_lang];
            },

            trans_message() {
                return this.message[this.safe_lang];
            },

            trans_button() {
                return this.button[this.safe_lang];
            }
        },

        mounted() {
            window.setTimeout(() => this.showModal = true, 500);
        }
    }
</script>
