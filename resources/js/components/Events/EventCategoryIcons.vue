<template>
    <div class="flex space-x-4 items-center">
        <run-icon
            class="w-8 block"
            :class="colour"
            v-if="categories.includes('run')"
        ></run-icon>
        <swim-icon
            class="w-8 block"
            :class="colour"
            v-if="categories.includes('swim')"
        ></swim-icon>
        <cycle-icon
            class="w-8 block"
            :class="colour"
            v-if="categories.includes('cycle')"
        ></cycle-icon>
        <training-icon
            class="w-8 block"
            :class="colour"
            v-if="categories.includes('training')"
        ></training-icon>
        <seminar-icon
            class="w-8 block"
            :class="colour"
            v-if="categories.includes('seminar')"
        ></seminar-icon>
        <lifestyle-icon
            class="w-8 block"
            :class="colour"
            v-if="categories.includes('lifestyle')"
        ></lifestyle-icon>
    </div>
</template>

<script type="text/babel">
import RunIcon from "./RunIcon";
import SwimIcon from "./SwimIcon";
import CycleIcon from "./CycleIcon";
import SeminarIcon from "./SeminarIcon";
import LifestyleIcon from "./LifestyleIcon";
import TrainingIcon from "./TrainingIcon";
export default {
    components: {
        RunIcon,
        SwimIcon,
        CycleIcon,
        SeminarIcon,
        LifestyleIcon,
        TrainingIcon,
    },

    props: ["categories", "colour"],
};
</script>
