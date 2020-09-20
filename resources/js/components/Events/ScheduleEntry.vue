<template>
    <div :data-id="item.id" class="flex mb-2 items-center">
        <div class="w-48">
            <p class="font-bold text-sm">{{ item.time_of_day.en }}</p>
            <p
                class="font-bold text-sm"
                v-if="item.time_of_day.zh !== item.time_of_day.en"
            >
                {{ item.time_of_day.zh }}
            </p>
        </div>
        <div class="flex-1">
            <p>{{ item.item.en }}</p>
            <p>{{ item.item.zh }}</p>
        </div>
        <div class="w-40">
            <button type="button" @click="deleteItem">
                Delete
            </button>
            <schedule-entry-form
                :entry="item"
                @updated="updateItem"
            ></schedule-entry-form>
        </div>
    </div>
</template>

<script type="text/babel">
import ScheduleEntryForm from "./ScheduleEntryForm";

export default {
    components: {
        ScheduleEntryForm,
    },

    props: ["item"],

    methods: {
        updateItem({ time_of_day, item }) {
            this.$emit("updated", {
                id: this.item.id,
                time_of_day,
                item,
                position: this.item.position,
            });
        },

        deleteItem() {
            this.$emit("removed", this.item);
        },
    },
};
</script>
