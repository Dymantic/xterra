<template>
    <section class="max-w-4xl mx-auto pt-4 pb-8">
        <div class="flex justify-between items-start">
            <div class="flex mb-2 text-sm font-bold">
                <div
                    v-for="(crumb, index) in breadcrumbs"
                    class="mr-2 flex items-center text-gray-800"
                >
                    <router-link
                        v-if="index !== breadcrumbs.length - 1"
                        :to="crumb.link"
                        class="hover:text-gray-800"
                        >{{ crumb.title }}</router-link
                    >
                    <span v-else class="text-gray-600">{{ crumb.title }}</span>
                    <div v-if="index < breadcrumbs.length - 1">
                        <chevron-right
                            class="ml-2 h-5 text-blue-600"
                        ></chevron-right>
                    </div>
                </div>
            </div>

            <div class="font-bold text-sm">
                <router-link v-if="backLink" :to="backLink"
                    >&larr; back</router-link
                >
            </div>
        </div>

        <div class="flex justify-between items-center">
            <h1 class="flex-1 text-3xl font-bold" :class="colour">
                {{ title }}
            </h1>
            <div class="flex justify-end items-center">
                <slot></slot>
            </div>
        </div>
    </section>
</template>

<script type="text/babel">
import ChevronRight from "./Icons/ChevronRight";
export default {
    components: {
        ChevronRight,
    },

    props: ["title", "colour", "breadcrumbs", "back-link"],
};
</script>
