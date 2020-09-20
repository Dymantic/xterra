<template>
    <div :data-id="fee.id" class="my-8 shadow p-6 relative">
        <p>
            <span>{{ fee.category.en }} / {{ fee.category.zh }}</span>
        </p>
        <p>
            <span>{{ fee.fee }}</span>
        </p>
        <div class="flex justify-end">
            <button class="mr-4 btn text-red-500" @click="removeItem">
                Remove
            </button>
            <fee-form :fee="fee" class="" @updated="onUpdate"></fee-form>
        </div>
    </div>
</template>

<script type="text/babel">
import FeeForm from "./FeeForm";
export default {
    components: {
        FeeForm,
    },

    props: ["fee"],

    methods: {
        onUpdate({ category, fee }) {
            this.$emit("updated", {
                id: this.fee.id,
                category,
                fee,
                position: this.fee.position,
            });
        },

        removeItem() {
            this.$emit("remove", this.fee.id);
        },
    },
};
</script>
