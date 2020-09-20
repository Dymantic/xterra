<template>
    <div class="" :class="{ 'border-b border-red-400': errorMsg }">
        <label class="flex items-center">
            <span class="text-sm font-bold">{{ label }}</span>
            <span class="text-xs text-red-400" v-show="errorMsg">{{
                errorMsg
            }}</span>
            <input
                ref="radio"
                type="radio"
                :name="value"
                :value="thing"
                @input="emit"
                class="hidden"
                :checked="thing === value"
            />
            <div
                class="ml-3 w-4 h-4 rounded-full border border-black fake-radio"
            ></div>
            <p class="my-1 text-gray-500 text-sm" v-show="helpText">
                {{ helpText }}
            </p>
        </label>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["value", "error-msg", "input-name", "label", "help-text", "thing"],

    computed: {},

    methods: {
        emit() {
            this.$emit("input", this.$refs.radio.value);
        },
    },
};
</script>

<style scoped>
input[type="radio"]:checked + .fake-radio {
    @apply bg-black;
}
</style>
