<template>
    <div class="">
        <div class="my-8 flex">
            <radio-input
                v-model="inner_lang"
                label="English"
                thing="en"
                class="mr-8"
            ></radio-input>
            <radio-input
                v-model="inner_lang"
                label="Chinese"
                thing="zh"
            ></radio-input>
        </div>
    </div>
</template>

<script type="text/babel">
import RadioInput from "./Forms/RadioInput";
export default {
    components: {
        RadioInput,
    },

    props: ["value"],

    data() {
        return {
            inner_lang: this.value,
        };
    },

    watch: {
        inner_lang() {
            this.$emit("input", this.inner_lang);
        },
    },
};
</script>
