<template>
    <span>
        <button class="btn" @click="showForm = true">{{ button_text }}</button>
        <modal :show="showForm" @close="showForm = false">
            <div class="w-screen max-w-lg p-6">
                <p class="text-lg font-bold">{{ form_title }}</p>

                <div class="my-6">
                    <p class="font-bold">Category</p>
                    <p class="my-2 text-gray-600">What is the fee for?</p>
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
                    <p class="font-bold">Fee</p>
                    <p class="my-2 text-gray-600">
                        What is the fee for this category?
                    </p>
                    <div class="pl-6">
                        <input-field
                            class="mb-4"
                            label="Fee"
                            v-model="category_fee"
                        ></input-field>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button @click="showForm = false" class="btn mr-4">
                        Cancel
                    </button>
                    <button
                        @click="emitFee"
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

    props: ["fee"],

    data() {
        return {
            showForm: false,
            category: { en: "", zh: "" },
            category_fee: "",
        };
    },

    computed: {
        is_edit() {
            return !!this.fee;
        },

        button_text() {
            return this.is_edit ? "Edit" : "Add Fee";
        },

        form_title() {
            return this.is_edit
                ? "Edit this fee"
                : "Add a new fee for the event";
        },

        incomplete() {
            return (
                this.category.en === "" ||
                this.category.zh === "" ||
                this.category_fee === ""
            );
        },

        fee_data() {
            return {
                category: this.category,
                fee: this.category_fee,
            };
        },
    },

    mounted() {
        if (this.fee) {
            this.category = this.fee.category;
            this.category_fee = this.fee.fee;
        }
    },

    methods: {
        emitFee() {
            this.showForm = false;
            if (this.is_edit) {
                return this.$emit("updated", this.fee_data);
            }
            this.$emit("added", this.fee_data);
            this.clearForm();
        },

        clearForm() {
            this.category = { en: "", zh: "" };
            this.category_fee = "";
        },
    },
};
</script>
