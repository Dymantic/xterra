<template>
    <div class="px-6" v-if="ready">
        <div class="flex justify-between mb-8 items-center">
            <p class="text-lg font-bold">General Event Info</p>
            <delete-event :event="currentEvent"></delete-event>
        </div>

        <form @submit.prevent="submit">
            <div class="my-6">
                <p class="font-bold">Name</p>
                <p class="my-2 text-gray-600">The name for this event</p>
                <div class="pl-6">
                    <input-field
                        class="mb-4"
                        label="English"
                        :error-msg="formErrors['name.en']"
                        v-model="formData.name.en"
                    ></input-field>
                    <input-field
                        class="my-4"
                        label="Chinese"
                        :error-msg="formErrors['name.zh']"
                        v-model="formData.name.zh"
                    ></input-field>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold">Intro</p>
                <p class="my-2 text-gray-600">
                    A brief description of the event.
                </p>
                <div class="pl-6">
                    <textarea-field
                        class="mb-4"
                        label="English"
                        :error-msg="formErrors.intro"
                        v-model="formData.intro.en"
                    ></textarea-field>
                    <textarea-field
                        class="my-4"
                        label="Chinese"
                        v-model="formData.intro.zh"
                    ></textarea-field>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold">Event Dates</p>
                <p class="my-2 text-gray-600">When will the event occur?</p>
                <div class="pl-6 flex justfiy-between">
                    <date-field
                        class="my-6 mr-6"
                        :inline="true"
                        label="Start Date"
                        help-text="When does the event start"
                        :error-msg="formErrors.start"
                        v-model="formData.start"
                    ></date-field>
                    <date-field
                        class="my-6"
                        label="End Date"
                        :inline="true"
                        help-text="When does the event end"
                        :error-msg="formErrors.end"
                        v-model="formData.end"
                    ></date-field>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold">Location</p>
                <p class="my-2 text-gray-600">
                    The general area where the event will be held (e.g. Kenting)
                </p>
                <div class="pl-6">
                    <input-field
                        class="mb-4"
                        label="English"
                        :error-msg="formErrors['location.en']"
                        v-model="formData.location.en"
                    ></input-field>
                    <input-field
                        class="my-4"
                        label="Chinese"
                        :error-msg="formErrors['location.zh']"
                        v-model="formData.location.zh"
                    ></input-field>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold">Venue</p>
                <p class="my-2 text-gray-600">
                    The name of the actual venue
                </p>
                <div class="pl-6">
                    <input-field
                        class="mb-4"
                        label="English"
                        :error-msg="formErrors['venue_name.en']"
                        v-model="formData.venue_name.en"
                    ></input-field>
                    <input-field
                        class="my-4"
                        label="Chinese"
                        :error-msg="formErrors['venue_name.zh']"
                        v-model="formData.venue_name.zh"
                    ></input-field>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold">Venue Address</p>
                <p class="my-2 text-gray-600">
                    The actual address for the event
                </p>
                <div class="pl-6">
                    <input-field
                        class="mb-4"
                        label="English"
                        :error-msg="formErrors['venue_address.en']"
                        v-model="formData.venue_address.en"
                    ></input-field>
                    <input-field
                        class="my-4"
                        label="Chinese"
                        :error-msg="formErrors['venue_address.zh']"
                        v-model="formData.venue_address.zh"
                    ></input-field>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold">Map Link</p>
                <p class="my-2 text-gray-600">
                    A valid link for an online map, such as Google Maps
                </p>
                <div class="pl-6">
                    <input-field
                        class="my-6"
                        label=""
                        help-text="You must include the http:// or https:// part"
                        :error-msg="formErrors.venue_maplink"
                        v-model="formData.venue_maplink"
                    ></input-field>
                </div>
            </div>

            <div class="my-6">
                <p class="font-bold">Registration Link</p>
                <p class="my-2 text-gray-600">
                    A valid link for registration for the event
                </p>
                <div class="pl-6">
                    <input-field
                        class="my-6"
                        label=""
                        help-text="You must include the http:// or https:// part"
                        :error-msg="formErrors.registration_link"
                        v-model="formData.registration_link"
                    ></input-field>
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <submit-button :waiting="waiting" type="submit">
                    Submit
                </submit-button>
            </div>
        </form>
    </div>
</template>

<script type="text/babel">
import InputField from "../Forms/InputField";
import DateField from "../Forms/DateField";
import SubmitButton from "../Forms/SubmitButton";
import DeleteEvent from "./DeleteEvent";
import TextareaField from "../Forms/TextareaField";
import { clearValidationErrors, setValidationErrors } from "../../lib/forms";
import { notify } from "../Messaging/notify";
import {toStandardDateString} from "../../lib/dates";
export default {
    components: {
        InputField,
        TextareaField,
        DateField,
        SubmitButton,
        DeleteEvent,
    },

    data() {
        return {
            ready: false,
            waiting: false,
            formData: {
                name: { en: "", zh: "" },
                intro: { en: "", zh: "" },
                location: { en: "", zh: "" },
                venue_name: { en: "", zh: "" },
                venue_address: { en: "", zh: "" },
                venue_maplink: "",
                registration_link: "",
                start: toStandardDateString(new Date()),
                end: toStandardDateString(new Date()),
            },
            formErrors: {
                "name.en": "",
                "name.zh": "",
                intro: "",
                "location.en": "",
                "location.zh": "",
                "venue_name.en": "",
                "venue_name.zh": "",
                "venue_address.en": "",
                "venue_address.zh": "",
                venue_maplink: "",
                registration_link: "",
                start: "",
                end: "",
            },
        };
    },

    computed: {
        currentEvent() {
            return this.$store.state.events.current_page_event;
        },
    },

    mounted() {
        this.$store
            .dispatch("events/getCurrentPage", this.$route.params.id)
            .then(this.setForm);
    },

    methods: {
        setForm(event) {
            this.formData = {
                name: { en: event.name.en, zh: event.name.zh },
                intro: { en: event.intro.en, zh: event.intro.zh },
                location: { en: event.location.en, zh: event.location.zh },
                venue_name: {
                    en: event.venue_name.en,
                    zh: event.venue_name.zh,
                },
                venue_address: {
                    en: event.venue_address.en,
                    zh: event.venue_address.zh,
                },
                venue_maplink: event.venue_maplink,
                registration_link: event.registration_link,
                start: toStandardDateString(event.start ? new Date(event.start) : new Date()),
                end: toStandardDateString(event.end ? new Date(event.end) : new Date()),
            };
            this.ready = true;
        },

        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            this.$store
                .dispatch("events/updateGeneralInfo", {
                    event_id: this.currentEvent.id,
                    formData: this.formData,
                })
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            notify.success({ message: "Event info updated." });
        },

        onError({ status, data }) {
            if (status === 422) {
                notify.warn({ message: "Some input was invalid" });
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }

            notify.error({ message: "Unable to save info." });
        },
    },
};
</script>
