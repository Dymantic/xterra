<template>
    <div>
        <div class="mb-12">
            <p class="font-bold text-lg">Page Publish Status</p>
        </div>

        <div class="my-12">
            <div class="flex justify-between items-center shadow p-6">
                <div class="max-w-md">
                    <colour-label
                        :colour="status.colour"
                        :text="status.text"
                    ></colour-label>
                    <p class="text-sm my-4">{{ status.desc }}</p>
                </div>
                <div>
                    <submit-button
                        :waiting="waiting"
                        :mode="page.is_public ? 'danger' : 'main'"
                        role="button"
                        @click.native="toggle"
                        >{{
                            page.is_public ? "Retract" : "Publish"
                        }}</submit-button
                    >
                </div>
            </div>
            <div class="my-12" v-if="page.is_draft">
                <p>
                    <strong>Note: </strong>This page's unique slug is currently
                    <strong>/{{ page.slug }}</strong
                    >. Once you publish this page, that will become permanent,
                    so first make sure there are no errors in your title.
                </p>
            </div>

            <div class="my-12 shadow p-6">
                <p class="font-bold">Previews</p>
                <p class="my-4">
                    You may preview the page here without having to publish it.
                </p>
                <div class="">
                    <a
                        target="_blank"
                        class="text-blue-700 hover:underline mr-20"
                        :href="`/previews/discover/pages/${page.id}?lang=en`"
                        >English Preview</a
                    >
                    <a
                        target="_blank"
                        class="text-blue-700 hover:underline"
                        :href="`/previews/discover/pages/${page.id}?lang=zh`"
                        >Chinese Preview</a
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import ColourLabel from "../ColourLabel";
import { notify } from "../Messaging/notify";
import SubmitButton from "../Forms/SubmitButton";
export default {
    components: { SubmitButton, ColourLabel },
    props: ["page"],

    data() {
        return {
            waiting: false,
        };
    },

    computed: {
        status() {
            if (this.page.is_public) {
                return {
                    text: "Live",
                    colour: "green",
                    desc:
                        "This page is currently live on the site and may be visited by anyone.",
                };
            }

            return this.page.is_draft
                ? {
                      text: "Draft",
                      colour: "orange",
                      desc:
                          "This page is still a draft, and has never been published. It cannot be seen by the public.",
                  }
                : {
                      text: "Private",
                      colour: "red",
                      desc:
                          "This page has been published before, but has been marked as private for now. It can not be viewed by the public.",
                  };
        },
    },

    methods: {
        toggle() {
            this.waiting = true;
            const action = this.page.is_public
                ? "pages/retract"
                : "pages/publish";

            this.$store
                .dispatch(action, this.page.id)
                .catch(() =>
                    notify.error({ message: "Unable to set publish status" })
                )
                .then(() => (this.waiting = false));
        },
    },
};
</script>
