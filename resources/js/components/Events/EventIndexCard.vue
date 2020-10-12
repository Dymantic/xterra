<template>
    <div class="rounded-lg shadow-lg py-4 px-6">
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
</template>

<script type="text/babel">
import EventCategoryIcons from "./EventCategoryIcons";
export default {
    components: {
        EventCategoryIcons,
    },

    props: ["event"],
};
</script>
