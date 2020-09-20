<template>
    <span>
        <button @click="showModal = true" class="btn btn-dark">
            Select Promotion
        </button>
        <modal :show="showModal" @close="showModal = false">
            <div class="max-w-xl w-screen p-6">
                <p class="font-bold text-lg mb-6">Select a Promotion</p>
                <div>
                    <input-field
                        label="Search"
                        placeholder="Filter by English name"
                        v-model="search"
                    ></input-field>
                </div>
                <div class="h-80 pt-6 overflow-auto">
                    <div
                        v-for="promo in options"
                        :key="promo.id"
                        class="border-b border-gray-300 flex justify-between items-center p-2 my-4"
                    >
                        <div class="flex items-center">
                            <div class="h-12 w-16 mr-4">
                                <img
                                    :src="promo.image.thumb"
                                    class="w-full h-full object-cover"
                                    alt=""
                                />
                            </div>
                            <p class="font-bold mb-1">{{ promo.title.en }}</p>
                        </div>
                        <button
                            class="font-bold text-sm hover:text-blue-600"
                            @click="selectPromotion(promo)"
                        >
                            Select
                        </button>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="button" class="btn" @click="close">
                        Cancel
                    </button>
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
import Modal from "@dymantic/modal";
import InputField from "../Forms/InputField";

export default {
    components: {
        InputField,
    },

    data() {
        return {
            showModal: false,
            search: "",
        };
    },

    computed: {
        promotions() {
            return this.$store.state.promotions.all;
        },

        options() {
            if (this.search === "") {
                return this.promotions;
            }
            return this.events.filter((promo) =>
                promo.title.en.toLowerCase().includes(this.search.toLowerCase())
            );
        },
    },

    created() {
        this.$store.dispatch("promotions/fetchAll");
    },

    methods: {
        selectPromotion(promo) {
            this.$emit("promo-selected", promo);
            this.close();
        },

        close() {
            this.search = "";
            this.showModal = false;
        },
    },
};
</script>
