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
            <select
                ref="input"
                @input="emit"
                class="mt-1 w-full block border p-2"
            >
                <option
                    :selected="value === val"
                    v-for="(option, val) in options"
                    :value="val"
                    >{{ option }}</option
                >
            </select>
        </label>
    </div>
</template>

<script type="text/babel">
export default {
    props: [
        "value",
        "error-msg",
        "input-name",
        "label",
        "type",
        "help-text",
        "options",
    ],

    computed: {
        inputType() {
            return this.type || "text";
        },
    },

    mounted() {
        this.$emit("input", this.$refs.input.value);
    },

    methods: {
        emit() {
            this.$emit("input", this.$refs.input.value);
        },
    },
};
</script>
