<template>
    <span>
        <button class="btn btn-dark" @click="doAction" :disabled="waiting">{{ action_text }}</button>
        <modal :show="showPublishPanel" @close="showPublishPanel = false">
            <div class="p-8">
                <p class="text-lg font-bold">Publish this translation</p>
                <p class="text-sm text-gray-600 my-4">Ensure that your translation has an intro and a description.</p>
                <p class="text-red-500 my-4">{{ publish_error }}</p>
                <date-picker v-model="publish_date" :inline="true"></date-picker>
                <div class="flex justify-end mt-8">
                    <button @click="showPublishPanel = false" class="mr-4">Cancel</button>
                    <button :disabled="waiting" @click="publish" class="btn btn-dark">Publish</button>
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    import Modal from "@dymantic/modal";
    import DatePicker from "vuejs-datepicker";
    import {notify} from "../Messaging/notify";

    export default {
        components: {
            Modal,
            DatePicker,
        },

        props: ['is-published', 'translation-id'],

        data() {
            return {
                showPublishPanel: false,
                publish_date: new Date(),
                publish_error: '',
                waiting: false,
            };
        },

        computed: {
            action_text() {
                return this.isPublished ? 'Retract' : 'Publish';
            }
        },

        methods: {
            doAction() {
                if(this.isPublished) {
                    return this.retract();
                }

                this.showPublishForm();
            },

            retract() {
                this.waiting = true;
                this.$store.dispatch('articles/retractTranslation', this.translationId)
                    .then(this.onRetracted)
                    .catch(this.retractError)
                    .then(() => this.waiting = false);
            },

            onRetracted(translation) {
                this.showPublishPanel = false;
                this.$emit('translation-updated', translation);
            },

            retractError() {
                this.showPublishPanel = false;
                notify.error({message: 'Unable to retract translation.'});
            },

            showPublishForm() {
                this.showPublishPanel = true;
            },

            publish() {
                this.waiting = true;
                this.publish_error = '';
                this.$store.dispatch('articles/publishTranslation', {
                    translation_id: this.translationId,
                    publish_date: this.publish_date.toISOString().slice(0,10),
                })
                    .then(this.onPublished)
                    .catch(this.publishError)
                    .then(() => this.waiting = false);
            },

            onPublished(translation) {
                this.showPublishPanel = false;
                this.$emit('translation-updated', translation);
            },

            publishError({status}) {
                if(status === 422) {
                    return this.publish_error = 'Please select a valid date, not in the past.'
                }
                this.showPublishPanel = false;
                notify.error({message: 'Unable to publish translation.'});
            }
        }
    }
</script>