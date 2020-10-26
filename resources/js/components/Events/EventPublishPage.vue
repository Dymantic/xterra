<template>
    <div v-if="event">
        <div class="flex justify-between mb-12">
            <p class="text-lg font-bold">Event Publish Status</p>
            <div class="flex justify-end"></div>
        </div>

        <div class="flex justify-between items-start">
            <div class="">
                <colour-label
                    :text="event.is_public ? 'Live' : 'Draft'"
                    :colour="event.is_public ? 'green' : 'red'"
                    >Live</colour-label
                >
                <p class="max-w-md text-gray-600 mt-3">{{ status }}</p>
            </div>

            <submit-button
                :waiting="waiting"
                :mode="event.is_public ? 'danger' : 'main'"
                role="button"
                @click.native="toggleStatus"
                >{{ button_text }}</submit-button
            >
        </div>
        <div class="my-12">
            <p class="text-lg font-bold">Previews</p>
            <p class="my-8 text-gray-600 max-w-lg">
                Use the links below to see a preview of what the event will look
                like on the front end without having to publish it.
            </p>

            <div>
                <a
                    class="text-blue-700 hover:text-blue-500 font-bold"
                    :href="`/previews/events/${$route.params.id}?lang=en`"
                    target="_blank"
                    >English Preview</a
                >
                <a
                    class="ml-8 text-blue-700 hover:text-blue-500 font-bold"
                    :href="`/previews/events/${$route.params.id}?lang=zh`"
                    target="_blank"
                    >Chinese Preview</a
                >
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import SubmitButton from "../Forms/SubmitButton";
import ColourLabel from "../ColourLabel";
import { notify } from "../Messaging/notify";
export default {
    components: { SubmitButton, ColourLabel },

    data() {
        return {
            waiting: false,
        };
    },

    computed: {
        event() {
            return this.$store.state.events.current_page_event;
        },

        button_text() {
            return this.event.is_public ? "Retract" : "Publish";
        },

        status() {
            return this.event.is_public
                ? `${this.event.name.en} has been published and is publicly visible.`
                : `${this.event.name.en} is currently in draft mode and is not visible to the public.`;
        },
    },

    methods: {
        toggleStatus() {
            this.waiting = true;
            const action = this.event.is_public
                ? "events/retract"
                : "events/publish";
            this.$store
                .dispatch(action, this.$route.params.id)
                .then(() => {
                    notify.success({ message: "Event status updated" });
                })
                .catch(() =>
                    notify.error({ message: "Failed to save event status." })
                )
                .then(() => (this.waiting = false));
        },
    },
};
</script>
