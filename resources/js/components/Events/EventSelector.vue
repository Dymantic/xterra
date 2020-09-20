<template>
    <span>
        <button @click="showModal = true" class="btn btn-dark">
            Select Event
        </button>
        <modal :show="showModal" @close="showModal = false">
            <div class="max-w-xl w-screen p-6">
                <p class="font-bold text-lg mb-6">Select an Event</p>
                <div>
                    <input-field
                        label="Search"
                        placeholder="Filter by English name"
                        v-model="search"
                    ></input-field>
                </div>
                <div class="h-80 pt-6 overflow-auto">
                    <div
                        v-for="event in options"
                        :key="event.id"
                        class="border-b border-gray-300 flex justify-between items-center p-2 my-4"
                    >
                        <div>
                            <p class="font-bold mb-1">{{ event.name.en }}</p>
                            <p class="text-gray-600 text-sm">
                                <span>{{ event.location.en }}</span>
                                <span
                                    class="pl-4 ml-4 border-l border-gray-400"
                                    v-if="event.dates"
                                    >{{ event.dates }}</span
                                >
                            </p>
                        </div>
                        <button
                            class="font-bold text-sm hover:text-blue-600"
                            @click="selectEvent(event)"
                        >
                            Select
                        </button>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="button" class="btn" @click="close">
                        Cancel
                    </button>
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
import Modal from "@dymantic/modal";
import InputField from "../Forms/InputField";

export default {
    components: {
        InputField,
    },

    data() {
        return {
            showModal: false,
            search: "",
        };
    },

    computed: {
        events() {
            return this.$store.state.events.all;
        },

        options() {
            if (this.search === "") {
                return this.events;
            }
            return this.events.filter((event) =>
                event.name.en.toLowerCase().includes(this.search.toLowerCase())
            );
        },
    },

    created() {
        this.$store.dispatch("events/fetchAll");
    },

    methods: {
        selectEvent(event) {
            this.$emit("event-selected", event);
            this.close();
        },

        close() {
            this.search = "";
            this.showModal = false;
        },
    },
};
</script>
