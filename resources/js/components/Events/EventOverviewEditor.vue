<template>
    <div v-if="event">
        <div class="flex justify-between items-center mb-6">
            <p class="font-bold text-lg">Writeup for the event</p>
            <submit-button :waiting="waiting" @click.native="save" role="button"
                >Save</submit-button
            >
        </div>
        <div>
            <button
                :class="{ 'font-bold underline': lang === 'en' }"
                @click="lang = 'en'"
                class="mr-6"
            >
                English
            </button>
            <button
                :class="{ 'font-bold underline': lang === 'zh' }"
                @click="lang = 'zh'"
            >
                Chinese
            </button>
        </div>
        <div>
            <wysiwyg
                v-show="lang === 'en'"
                v-model="formData.overview.en"
            ></wysiwyg>
            <wysiwyg
                v-show="lang === 'zh'"
                v-model="formData.overview.zh"
            ></wysiwyg>
        </div>
    </div>
</template>

<script type="text/babel">
import Wysiwyg from "@dymantic/vue-trix-editor";
import SubmitButton from "../Forms/SubmitButton";
import { notify } from "../Messaging/notify";
export default {
    components: {
        SubmitButton,
        Wysiwyg,
    },

    data() {
        return {
            lang: "en",
            waiting: false,
            formData: {
                overview: { en: "", zh: "" },
            },
        };
    },

    computed: {
        event() {
            return this.$store.state.events.current_page_event;
        },
    },

    mounted() {
        this.formData = {
            overview: {
                en: this.event.overview.en,
                zh: this.event.overview.zh,
            },
        };
    },

    methods: {
        save() {
            this.waiting = true;

            this.$store
                .dispatch("events/updateOverview", {
                    event_id: this.$route.params.id,
                    formData: this.formData,
                })
                .then(() => notify.success({ message: "Writeup saved." }))
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onError({ status, data }) {
            notify.error({ message: "Unable to save writeup" });
        },
    },
};
</script>
