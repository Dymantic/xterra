<template>
    <div :data-id="prize.id" class="my-8 shadow p-6 relative">
        <p>
            <span>{{ prize.category.en }} - {{ prize.prize.en }}</span>
        </p>
        <div class="my-3 w-64 border-b"></div>
        <p>
            <span>{{ prize.category.zh }} - {{ prize.prize.zh }}</span>
        </p>
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
