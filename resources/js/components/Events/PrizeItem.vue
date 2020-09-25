<template>
    <div :data-id="prize.id" class="my-8 shadow p-6 relative">
        <div class="flex">
            <div class="w-64">
                <p class="text-xs">Category</p>
                <p>{{ prize.category.en }}</p>
                <p>{{ prize.category.zh }}</p>
            </div>
            <div class="">
                <p class="text-xs">Prize</p>
                <p>{{ prize.prize.en }}</p>
                <p>{{ prize.prize.zh }}</p>
            </div>
        </div>

        <div class="flex justify-end">
            <button class="mr-4 btn text-red-500" @click="removeItem">
                Remove
            </button>
            <prize-form :initial="prize" @updated="onUpdate"></prize-form>
        </div>
    </div>
</template>

<script type="text/babel">
import PrizeForm from "./PrizeForm";
export default {
    components: {
        PrizeForm,
    },

    props: ["prize"],

    methods: {
        onUpdate({ category, prize }) {
            this.$emit("updated", {
                id: this.initial.id,
                category,
                prize,
                position: this.initial.position,
            });
        },

        removeItem() {
            this.$emit("remove", this.prize.id);
        },
    },
};
</script>
