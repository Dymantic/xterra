<template>
    <div :class="notificationClasses"
         class="fixed alert-box mx-auto max-w-sm w-full rounded shadow leading-normal border bg-white">
        <div>
            <header class="text-white text-center font-bold py-3">{{ title }}</header>
            <p class="p-8 text-center">{{ message }}</p>
            <p v-if="status === 'error'" class="text-center">Refresh the page, and try again.</p>
        </div>
        <div class="flex justify-end py-4 px-8">
            <button @click="show = false">Okay</button>
        </div>
    </div>
</template>

<script type="text/babel">
    import {EventBus} from "./EventBus";

    export default {
        data() {
            return {
                show: false,
                status: 'error',
                title: '',
                message: '',
                timeout: null
            };
        },

        computed: {
            notificationClasses() {
                return {
                    'in-active': !this.show,
                    'error': this.status === 'error',
                    'success': this.status === 'success',
                    'warning': this.status === 'warning'
                };
            }
        },

        mounted() {
            EventBus.$on('notify', this.handleNotification);
            EventBus.$on('notify:error', this.handleErrorNotification);
            EventBus.$on('notify:success', this.handleSuccessNotification);
            EventBus.$on('notify:warning', this.handleWarningNotification);

            window.addEventListener('keyup', ({key}) => {
                if (key === 'Escape') {
                    this.show = false;
                }
            });

            window.addEventListener('load', this.checkFlashMessages);


        },
        methods: {
            handleNotification({type, title = 'Notification', message, clear}) {
                this.status = type;
                this.title = title;
                this.message = message;
                this.showNotification(clear);
            },

            handleErrorNotification({title = 'Error', message, clear}) {
                this.status = 'error';
                this.title = title;
                this.message = message;
                this.showNotification(clear);
            },

            handleSuccessNotification({title = 'Success!', message, clear = true}) {
                this.status = 'success';
                this.title = title;
                this.message = message;
                this.showNotification(clear);
            },

            handleWarningNotification({title = 'Hold on!', message, clear = true}) {
                this.status = 'warning';
                this.title = title;
                this.message = message;
                this.showNotification(clear);
            },

            showNotification(clear) {
                this.show = true;

                if(clear) {
                    if(this.timeout) {
                        window.clearTimeout(this.timeout);
                    }

                    this.timeout = window.setTimeout(() => this.show = false, 2000);
                }
            },

            checkFlashMessages() {
                if(window.flashMessage) {
                    this.handleNotification(window.flashMessage);
                }
            }
        }
    }
</script>

<style scoped
       lang="less"
       type="text/css">
    .alert-box {
        bottom: 50px;
        left: 50%;
        transform-origin: center center;
        transform: scale(1) translate3d(-50%, 0, 0);
        opacity: 1;
        transition: .2s ease-in-out;
        visibility: visible;
    }

    .alert-box.in-active {
        opacity: 0;
        transform: scale(.8) translate3d(-50%, 40px, 0);
        visibility: hidden;
        pointer-events: none;
    }

    .alert-box.error {
        @apply .border-red-400;
    }

    .alert-box.success {
        @apply .border-green-400;
    }

    .alert-box.warning {
        @apply .border-orange-600;
    }

    .alert-box.error header {
        @apply .bg-red-400;
    }

    .alert-box.success header {
        @apply .bg-green-400;
    }

    .alert-box.warning header {
        @apply .bg-orange-600;
    }
</style>