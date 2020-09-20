<template>
    <div>
        <div class="flex justify-between">
            <p class="text-lg font-bold">Event Schedule</p>
            <div class="flex items-center">
                <submit-button
                    :waiting="waiting"
                    role="button"
                    @click.native="save"
                >
                    Save
                </submit-button>
                <button
                    :disabled="waiting"
                    type="button"
                    @click="clearSchedule"
                    class="btn"
                >
                    Clear Schedule
                </button>
            </div>
        </div>

        <div class="my-8">
            <button @click="addNextDay" class="btn btn-dark">
                Add Day {{ getNextDayNumber() }}
            </button>
            <button
                @click="addPreviousNextDay"
                class="btn ml-4"
                v-if="schedule.length"
            >
                Add Day {{ getPreviousDayNumber() }}
            </button>
        </div>

        <div class="pt-12">
            <div v-for="day in schedule" :key="day.day" class="mb-12">
                <div class="flex justify-between border-b border-gray-300 mb-3">
                    <p class="font-bold text-lg">Day {{ day.day }}</p>
                    <schedule-entry-form
                        :day-number="day.day"
                        @updated="addEntryToDay"
                    ></schedule-entry-form>
                </div>
                <div :ref="`day_list_${day.day}`">
                    <schedule-entry
                        v-for="item in day.entries.list"
                        :key="item.id"
                        :item="item"
                        @updated="updateDayEntry($event, day.day)"
                        @removed="day.entries.deleteById(item.id)"
                    ></schedule-entry>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import ScheduleEntryForm from "./ScheduleEntryForm";
import ScheduleEntry from "./ScheduleEntry";
import SubmitButton from "../Forms/SubmitButton";
import Sortable from "sortablejs";
import { PositionedList } from "../../lib/PositionedList";
import { notify } from "../Messaging/notify";

export default {
    components: {
        ScheduleEntry,
        ScheduleEntryForm,
        SubmitButton,
    },

    data() {
        return {
            waiting: false,
            schedule: [],
            sortables: [],
        };
    },

    computed: {
        scheduleDays() {
            return this.schedule.map((day) => day.day);
        },
    },

    mounted() {
        const days = this.$store.getters["events/currentEventSchedule"];
        days.forEach((day) => this.addExistingDay(day));
    },

    methods: {
        getNextDayNumber() {
            if (this.scheduleDays.length === 0) {
                return 1;
            }

            return this.scheduleDays.sort((a, b) => a - b).reverse()[0] + 1;
        },

        getPreviousDayNumber() {
            if (this.scheduleDays.length === 0) {
                return 1;
            }

            return this.scheduleDays.sort((a, b) => a - b)[0] - 1;
        },

        addNextDay(day) {
            this.addDay(this.getNextDayNumber(), []);
        },

        addPreviousNextDay() {
            this.addDay(this.getPreviousDayNumber(), []);
        },

        addExistingDay(day) {
            this.addDay(day.day, day.entries);
        },

        addDay(day, list) {
            this.schedule = [
                ...this.schedule,
                { day: day, entries: PositionedList.New(list) },
            ];

            this.$nextTick().then(() => {
                this.sortables = [
                    ...this.sortables,
                    {
                        id: day,
                        sortable: new Sortable(
                            this.$refs[`day_list_${day}`][0],
                            { onSort: () => this.onSorted(day) }
                        ),
                    },
                ];
            });
        },

        onSorted(day_number) {
            const schedule_day = this.schedule.find(
                (d) => d.day === day_number
            );
            const sortable = this.sortables.find((s) => s.id === day_number);
            if (schedule_day && sortable) {
                console.log({ sortable });
                schedule_day.entries.repositionList(
                    sortable.sortable.toArray()
                );
            }
        },

        addEntryToDay({ day, time_of_day, item }) {
            const schedule_day = this.schedule.find((d) => d.day === day);
            schedule_day.entries.addItem({ time_of_day, item });
        },

        updateDayEntry(item, day) {
            const schedule_day = this.schedule.find((d) => d.day === day);
            schedule_day.entries.updateItem(item);
        },

        save() {
            this.waiting = true;
            const schedule = this.schedule.map((day) => {
                return {
                    day: day.day,
                    entries: day.entries.toArray(),
                };
            });
            this.$store
                .dispatch("events/saveSchedule", {
                    event_id: this.$route.params.id,
                    schedule,
                })
                .then(() => notify.success({ message: "Schedule updated." }))
                .catch(() =>
                    notify.error({ message: "Failed to update schedule" })
                )
                .then(() => (this.waiting = false));
        },

        clearSchedule() {
            this.waiting = true;
            this.schedule = [];
            this.$store
                .dispatch("events/clearSchedule", this.$route.params.id)
                .then(() => notify.success({ message: "Schedule cleared." }))
                .catch(() =>
                    notify.error({ message: "Failed to clear schedule" })
                )
                .then(() => (this.waiting = false));
        },
    },
};
</script>
