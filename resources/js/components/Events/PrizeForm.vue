<template>
    <span>
        <button class="btn" @click="showModal = true">
            {{ initial ? "Edit" : "Add Prize" }}
        </button>
        <modal :show="showModal" @close="showModal = false">
            <div class="w-screen max-w-lg p-6">
                <p class="text-lg font-bold">{{ form_title }}</p>
                <div class="my-6">
                    <p class="font-bold">Category</p>
                    <p class="my-2 text-gray-600">What is the prize for?</p>
                    <div class="pl-6">
                        <input-field
                            class="mb-4"
                            label="English"
                            v-model="category.en"
                        ></input-field>
                        <input-field
                            class="mb-4"
                            label="Chinese"
                            v-model="category.zh"
                        ></input-field>
                    </div>
                </div>

                <div class="my-6">
                    <p class="font-bold">Prize</p>
                    <p class="my-2 text-gray-600">What is the actual prize?</p>
                    <div class="pl-6">
                        <input-field
                            class="mb-4"
                            label="English"
                            v-model="prize.en"
                        ></input-field>
                        <input-field
                            class="mb-4"
                            label="Chinese"
                            v-model="prize.zh"
                        ></input-field>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button @click="showModal = false" class="btn mr-4">
                        Cancel
                    </button>
                    <button
                        @click="emitPrize"
                        :disabled="incomplete"
                        class="btn btn-dark"
                    >
                        Done
                    </button>
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
import InputField from "../Forms/InputField";
export default {
    components: {
        InputField,
    },

    props: ["initial"],

    data() {
        return {
            showModal: false,
            category: { en: "", zh: "" },
            prize: { en: "", zh: "" },
        };
    },

    computed: {
        incomplete() {
            return (
                this.category.en === "" ||
                this.category.zh === "" ||
                this.prize.en === "" ||
                this.prize.zh === ""
            );
        },

        form_title() {
            return this.initial
                ? "Edit prize info"
                : "Add a prize for the event";
        },

        prize_data() {
            return {
                category: this.category,
                prize: this.prize,
            };
        },
    },

    mounted() {
        if (this.initial) {
            this.category = this.initial.category;
            this.prize = this.initial.prize;
        }
    },

    methods: {
        emitPrize() {
            this.showModal = false;
            if (this.initial) {
                return this.$emit("updated", this.prize_data);
            }
            this.$emit("added", this.prize_data);
            this.clearForm();
        },

        clearForm() {
            this.category = { en: "", zh: "" };
            this.prize = { en: "", zh: "" };
        },
    },
};
</script>
