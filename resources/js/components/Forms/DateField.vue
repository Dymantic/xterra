<template>
    <div class="" :class="{ 'border-b border-red-400': errorMsg }">
        <label class="">
            <span class="text-sm font-bold">{{ label }}</span>
            <span class="text-xs text-red-400" v-show="errorMsg">{{
                errorMsg
            }}</span>
            <p class="my-1 text-gray-500 text-sm" v-show="helpText">
                {{ helpText }}
            </p>
            <date-picker
                input-class="border p-2 w-full block max-w-xs"
                :inline="inline"
                @input="emit"
                v-model="internal_date"
            ></date-picker>
        </label>
    </div>
</template>

<script type="text/babel">
import DatePicker from "vuejs-datepicker";
import { toStandardDateString } from "../../lib/dates";
export default {
    components: {
        DatePicker,
    },

    props: [
        "value",
        "error-msg",
        "input-name",
        "label",
        "type",
        "help-text",
        "inline",
    ],

    data() {
        return {
            internal_date: new Date(this.value),
        };
    },

    watch: {
        value(to) {
            console.log(to);
        },
    },

    mounted() {
        console.log(this.value);
    },

    methods: {
        emit(date) {
            console.log("logd", toStandardDateString(date));
            this.$emit("input", toStandardDateString(date));
        },
    },
};
</script>
