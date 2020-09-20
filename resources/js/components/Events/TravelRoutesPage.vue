<template>
    <div v-if="event">
        <div class="mb-12">
            <p class="font-bold text-lg">Travel Guide</p>
            <p class="my-4">
                You may upload a travel guide document such as a PDF for site
                visitors to download.
            </p>
            <single-file-upload
                class="border-t border-gray-300 pt-2"
                :upload-path="`/admin/events/${event.id}/travel-guide`"
                :delete-path="`/admin/events/${event.id}/travel-guide`"
                :download-path="`${event.travel_guide}`"
                :filename="guide_filename"
                name="travel_guide"
                prompt="Upload your travel guide"
                @uploaded="handleUpload"
                @upload-failed="handleError"
                @invalid-file="handleInvalid"
                @cleared="handleCleared"
                @clear-failed="handleClearError"
            ></single-file-upload>
        </div>
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Travel Routes</p>
            <div class="items-center flex">
                <router-link
                    :to="`/events/${$route.params.id}/edit/travel-routes/create`"
                    class="btn btn-dark"
                    >Add Travel Route</router-link
                >
            </div>
        </div>

        <div class="my-12">
            <div
                v-for="route in travelRoutes"
                :key="route.id"
                class="shadow p-6 my-6 relative"
            >
                <p class="font-bold">{{ route.name.en }}</p>
                <p class="text-gray-600">{{ route.name.zh }}</p>
                <div class="flex justify-between">
                    <p class="my-4 text-sm w-1/2 mr-4">
                        {{ route.description.en }}
                    </p>
                    <p class="my-4 text-sm w-1/2 ml-4">
                        {{ route.description.zh }}
                    </p>
                </div>
                <div class="absolute top-0 right-0 mt-4 mr-4">
                    <router-link
                        class="font-bold hover:text-blue-600"
                        :to="`/events/${$route.params.id}/edit/travel-routes/${route.id}/edit`"
                        >Edit</router-link
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import SingleFileUpload from "../SingleFileUpload";
import { notify } from "../Messaging/notify";
export default {
    components: {
        SingleFileUpload,
    },

    computed: {
        travelRoutes() {
            return this.$store.getters["events/currentEventTravelRoutes"];
        },

        guide_filename() {
            const ext = this.event.travel_guide.split(".").pop();
            return `${this.event.name.en.replace(
                / /g,
                "_"
            )}_travel_guide.${ext}`;
        },

        event() {
            return this.$store.state.events.current_page_event;
        },
    },

    methods: {
        handleUpload() {
            notify.success({ message: "Travel guide uploaded" });
            this.$store.dispatch("events/refreshEvents");
        },

        handleInvalid(message) {
            notify.warn({ message });
        },

        handleError(message) {
            notify.error({ message });
        },

        handleCleared() {
            notify.success({ message: "Travel guide file removed" });
            this.$store.dispatch("events/refreshEvents");
        },

        handleClearError() {
            notify.error({ message: "Unable to remove file" });
        },
    },
};
</script>
