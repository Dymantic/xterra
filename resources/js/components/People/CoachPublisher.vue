<template>
    <div>
        <div class="flex justify-between items-center">
            <div class="max-w-sm">
                <colour-label
                    :colour="status_label.colour"
                    :text="status_label.text"
                ></colour-label>
                <p class="mt-2">{{ status }}</p>
            </div>
            <submit-button
                :waiting="waiting"
                role="button"
                @click.native="toggle"
                >{{ button_text }}</submit-button
            >
        </div>
    </div>
</template>

<script type="text/babel">
import SubmitButton from "../Forms/SubmitButton";
import { notify } from "../Messaging/notify";
import ColourLabel from "../ColourLabel";
export default {
    components: { ColourLabel, SubmitButton },

    props: ["coach"],

    data() {
        return {
            waiting: false,
        };
    },

    computed: {
        button_text() {
            return this.coach.is_public ? "Retract" : "Publish";
        },

        status() {
            if (this.coach.is_public) {
                return "This ambassador profile is currently public, and can be viewed on the website by the general public.";
            }
            return "This ambassador profile is currently private, and will not be shown on the website.";
        },

        status_label() {
            if (this.coach.is_public) {
                return {
                    colour: "green",
                    text: "live",
                };
            }
            return {
                colour: "orange",
                text: "draft",
            };
        },
    },

    methods: {
        toggle() {
            this.waiting = true;
            const action = this.coach.is_public
                ? "coaches/retract"
                : "coaches/publish";
            this.$store
                .dispatch(action, this.coach.id)
                .catch(() =>
                    notify.error({ message: "Failed to save public status" })
                )
                .then(() => (this.waiting = false));
        },
    },
};
</script>
