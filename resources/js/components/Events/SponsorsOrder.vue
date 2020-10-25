<template>
    <div v-if="event">
        <div class="flex justify-between items-center mb-12">
            <p class="font-bold text-lg">Sponsors Order</p>
            <div class="flex justify-end">
                <router-link
                    :to="`/events/${$route.params.id}/edit/sponsors`"
                    class="btn"
                    >Back</router-link
                >
            </div>
        </div>
        <p class="max-w-lg my-10">
            Drag and drop the sponsors into the order you desire. Your changes
            will be saved automatically.
        </p>
        <div>
            <div ref="sponsors" class="flex flex-wrap">
                <div
                    v-for="sponsor in event.sponsors"
                    :key="sponsor.id"
                    :data-id="sponsor.id"
                    class="w-32 h-32 m-4 border border-gray-300"
                >
                    <img
                        :src="sponsor.logo.thumb"
                        class="w-full h-full object-contain"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import Sortable from "sortablejs";
import { notify } from "../Messaging/notify";
export default {
    data() {
        return {
            sortable: null,
        };
    },

    computed: {
        event() {
            return this.$store.state.events.current_page_event;
        },
    },

    mounted() {
        this.sortable = new Sortable(this.$refs.sponsors, {
            onSort: this.handleSort,
        });
    },

    methods: {
        handleSort() {
            this.$store
                .dispatch("events/setSponsorsOrder", this.sortable.toArray())
                .catch(() => notify.error({ message: "Failed to save order" }));
        },
    },
};
</script>
