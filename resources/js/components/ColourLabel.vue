<template>
    <span
        class="inline-block px-2 py-1 rounded border text-xs"
        :class="colourClasses"
        >{{ text }}</span
    >
</template>

<script type="text/babel">
export default {
    props: ["colour", "text"],

    computed: {
        colourClasses() {
            const lookup = {
                green: "bg-green-200 border-green-500 text-green-700",
                red: "bg-red-200 border-red-500 text-red-700",
                orange: "bg-orange-200 border-orange-500 text-orange-700",
                purple: "bg-purple-200 border-purple-500 text-purple-700",
                teal: "bg-teal-200 border-teal-500 text-teal-700",
                indigo: "bg-indigo-200 border-indigo-500 text-indigo-700",
                gray: "bg-gray-200 border-gray-500 text-gray-700",
            };

            return (
                lookup[this.colour] ||
                "bg-gray-200 border-gray-500 text-gray-700"
            );
        },
    },
};
</script>
