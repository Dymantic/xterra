<template>
    <div class="my-8 p-6 shadow relative">
        <p class="font-bold">{{ activity.name[lang] }}</p>
        <category-colour-label
            class="my-2"
            :category="activity.category"
        ></category-colour-label>
        <p
            class="bg-red-500 px-2 py-1 text-white text-xs uppercase m-4 absolute top-0 right-0"
        >
            {{ activity.is_race ? "race" : "activity" }}
        </p>
        <router-link
            :to="`/events/${eventId}/races/${activity.id}/edit/general`"
            class="absolute bottom-0 right-0 m-4 text-gray-600 hover:text-red-700"
            >Edit</router-link
        >
    </div>
</template>

<script type="text/babel">
import CategoryColourLabel from "./CategoryColourLabel";

export default {
    components: {
        CategoryColourLabel,
    },

    props: ["activity", "lang", "event-id"],

    computed: {},
};
</script>
