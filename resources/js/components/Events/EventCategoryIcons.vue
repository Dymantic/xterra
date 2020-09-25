<template>
    <div class="flex space-x-4 items-center">
        <run-icon
            class="h-8 mr-2 block"
            :class="colour"
            v-if="categories.includes('run')"
        ></run-icon>
        <swim-icon
            class="h-8 mr-2 block"
            :class="colour"
            v-if="categories.includes('swim')"
        ></swim-icon>
        <cycle-icon
            class="h-8 mr-2 block"
            :class="colour"
            v-if="categories.includes('cycle')"
        ></cycle-icon>
        <duathlon-icon
            class="h-8 mr-2 block"
            :class="colour"
            v-if="categories.includes('duathlon')"
        ></duathlon-icon>
        <triathlon-icon
            class="h-8 mr-2 block"
            :class="colour"
            v-if="categories.includes('triathlon')"
        ></triathlon-icon>
        <training-icon
            class="h-8 mr-2 block"
            :class="colour"
            v-if="categories.includes('training')"
        ></training-icon>
        <seminar-icon
            class="h-8 mr-2 block"
            :class="colour"
            v-if="categories.includes('seminar')"
        ></seminar-icon>
        <lifestyle-icon
            class="h-8 mr-2 block"
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
import DuathlonIcon from "./DuathlonIcon";
import TriathlonIcon from "./TriathlonIcon";
export default {
    components: {
        RunIcon,
        SwimIcon,
        CycleIcon,
        SeminarIcon,
        LifestyleIcon,
        TrainingIcon,
        DuathlonIcon,
        TriathlonIcon,
    },

    props: ["categories", "colour"],
};
</script>
