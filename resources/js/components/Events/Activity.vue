<template>
    <div class="my-8 p-6 shadow relative">
        <p class="font-bold">{{ activity.name[lang] }}</p>
        <colour-label
            class="my-2"
            :colour="categoryColour"
            :text="activity.category"
        ></colour-label>
        <p class="text-gray-600 uppercase text-sm my-1">
            {{ activity.distance[lang] }}
        </p>
        <p class="my-4">{{ activity.description[lang] }}</p>
        <p
            class="bg-red-500 px-2 py-1 text-white text-xs uppercase m-4 absolute top-0 right-0"
        >
            {{ activity.is_race ? "race" : "activity" }}
        </p>
        <router-link
            :to="`/events/${eventId}/edit/activities/${activity.id}/edit`"
            class="absolute bottom-0 right-0 m-4 text-gray-600 hover:text-red-700"
            >Edit</router-link
        >
    </div>
</template>

<script type="text/babel">
import ColourLabel from "../ColourLabel";

export default {
    components: {
        ColourLabel,
    },

    props: ["activity", "lang", "event-id"],

    computed: {
        categoryColour() {
            const lookup = {
                run: "green",
                swim: "teal",
                cycle: "orange",
                seminar: "purple",
                lifestyle: "red",
                training: "indigo",
                other: "gray",
            };

            return lookup[this.activity.category] || "gray";
        },
    },
};
</script>
