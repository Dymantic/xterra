<template>
    <page>
        <page-header title="XTERRA Events">
            <create-event-form></create-event-form>
        </page-header>
        <div class="flex flex-col items-start">
            <div
                v-for="event in events_list"
                :key="event.id"
                class="rounded-lg shadow-lg py-4 px-6"
            >
                <div class="">
                    <p class="font-bold">
                        <router-link
                            :to="`/events/${event.id}`"
                            class="text-xl hover:text-blue-600"
                            >{{ event.name.en }}</router-link
                        >
                    </p>
                    <p class="my-2 text-gray-600">{{ event.dates }}</p>
                    <event-category-icons
                        :categories="event.categories"
                        colour="text-red-700"
                    ></event-category-icons>
                    <div class="w-120 h-60 mt-3 mx-auto">
                        <img
                            :src="event.banner_image.banner"
                            class="w-full h-full object-cover"
                            alt=""
                        />
                    </div>
                </div>
            </div>
        </div>
    </page>
</template>

<script type="text/babel">
import CreateEventForm from "./CreateEventForm";
import EventCategoryIcons from "./EventCategoryIcons";
export default {
    components: {
        CreateEventForm,
        EventCategoryIcons,
    },

    computed: {
        events_list() {
            return this.$store.state.events.all;
        },
    },

    mounted() {
        this.$store.dispatch("events/fetchAll");
    },
};
</script>
