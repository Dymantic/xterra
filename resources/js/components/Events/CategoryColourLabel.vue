<template>
    <colour-label
        class="my-2"
        :colour="categoryColour"
        :text="category"
    ></colour-label>
</template>

<script type="text/babel">
import ColourLabel from "../ColourLabel";
export default {
    components: {
        ColourLabel,
    },

    props: ["category"],

    computed: {
        categoryColour() {
            const lookup = {
                run: "green",
                swim: "teal",
                cycle: "orange",
                duathlon: "yellow",
                triathlon: "pink",
                seminar: "purple",
                lifestyle: "red",
                training: "indigo",
                other: "gray",
            };

            return lookup[this.category] || "gray";
        },
    },
};
</script>
