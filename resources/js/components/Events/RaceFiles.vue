<template>
    <div v-if="race">
        <div>
            <p class="text-lg font-bold">File uploads for {{ race.name.en }}</p>
        </div>
        <div class="my-12">
            <p class="font-bold mb-3">Race Rules and Info</p>
            <p class="text-gray-600 max-w-lg">
                Upload a file with the race rules and information.
            </p>
            <single-file-upload
                class="border-t border-gray-300 pt-2"
                :upload-path="`/admin/races/${$route.params.race}/race-rules-doc`"
                :delete-path="`/admin/races/${$route.params.race}/race-rules-doc`"
                :download-path="`${race.race_rules_document}`"
                :filename="rules_filename"
                name="rules_doc"
                prompt="Upload the race rules and info"
                @uploaded="handleUpload"
                @upload-failed="handleError"
                @invalid-file="handleInvalid"
                @cleared="handleCleared"
                @clear-failed="handleClearError"
            ></single-file-upload>
        </div>

        <div class="my-12">
            <p class="font-bold mb-3">Athlete's Guide</p>
            <p class="text-gray-600 max-w-lg">
                Upload the athlete's guide for this race.
            </p>
            <single-file-upload
                class="border-t border-gray-300 pt-2"
                :upload-path="`/admin/races/${$route.params.race}/athletes-guide`"
                :delete-path="`/admin/races/${$route.params.race}/athletes-guide`"
                :download-path="`${race.athletes_guide}`"
                :filename="athletes_guide_filename"
                name="athlete_guide"
                prompt="Upload the athlete guide"
                @uploaded="handleUpload"
                @upload-failed="handleError"
                @invalid-file="handleInvalid"
                @cleared="handleCleared"
                @clear-failed="handleClearError"
            ></single-file-upload>
        </div>
    </div>
</template>

<script type="text/babel">
import SingleFileUpload from "../SingleFileUpload";
import { notify } from "../Messaging/notify";
import { readableFilename } from "../../lib/files";
export default {
    components: {
        SingleFileUpload,
    },

    computed: {
        race() {
            return this.$store.getters["events/currentEventActivityById"](
                this.$route.params.race
            );
        },

        rules_filename() {
            return readableFilename(
                this.race.race_rules_document,
                this.race.name.en,
                "race_rules"
            );
        },

        athletes_guide_filename() {
            return readableFilename(
                this.race.athletes_guide,
                this.race.name.en,
                "athletes_guide"
            );
        },
    },

    methods: {
        handleUpload() {
            this.$store.dispatch("events/refreshEvents");
            notify.success({ message: "File saved" });
        },

        handleError() {
            notify.error({ message: "Failed to upload file" });
        },

        handleInvalid(message) {
            notify.warn({ message });
        },

        handleCleared() {
            this.$store.dispatch("events/refreshEvents");
            notify.success({ message: "File removed" });
        },

        handleClearError() {
            notify.error({ message: "Failed to remove file" });
        },
    },
};
</script>
