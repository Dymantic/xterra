<template>
    <span>
        <button @click="showModal = true" class="btn">
            {{ this.entry ? "Edit" : "Add Entry" }}
        </button>
        <modal :show="showModal" @close="showMOdal = true">
            <form @submit.prevent="done" class="w-screen max-w-2xl p-6">
                <div class="my-6 max-w-md">
                    <p class="font-bold">Time of Day</p>
                    <p class="my-2 text-gray-600">When is this happening?</p>
                    <div class="pl-6">
                        <input-field
                            class="mb-4"
                            label="English"
                            v-model="formData.time_of_day.en"
                        ></input-field>
                        <input-field
                            class="mb-4"
                            label="Chinese"
                            v-model="formData.time_of_day.zh"
                        ></input-field>
                    </div>
                </div>
                <div class="flex justify-between">
                    <div class="my-6">
                        <p class="font-bold">Activity</p>
                        <p class="my-2 text-gray-600">
                            What should be happening at ths time?
                        </p>
                        <div class="pl-6">
                            <input-field
                                class="mb-4"
                                label="English"
                                v-model="formData.item.en"
                            ></input-field>
                            <input-field
                                class="mb-4"
                                label="Chinese"
                                v-model="formData.item.zh"
                            ></input-field>
                        </div>
                    </div>

                    <div class="my-6">
                        <p class="font-bold">Location</p>
                        <p class="my-2 text-gray-600">
                            Where does the person need to be?
                        </p>
                        <div class="pl-6">
                            <input-field
                                class="mb-4"
                                label="English"
                                v-model="formData.location.en"
                            ></input-field>
                            <input-field
                                class="mb-4"
                                label="Chinese"
                                v-model="formData.location.zh"
                            ></input-field>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button
                        type="button"
                        @click="showModal = false"
                        class="mr-4 btn"
                    >
                        Cancel
                    </button>
                    <button
                        :disabled="incomplete"
                        type="submit"
                        class="btn btn-dark"
                    >
                        Done
                    </button>
                </div>
            </form>
        </modal>
    </span>
</template>

<script type="text/babel">
import InputField from "../Forms/InputField";

export default {
    components: {
        InputField,
    },

    props: ["entry", "day-number"],

    data() {
        return {
            showModal: false,
            formData: {
                time_of_day: {
                    en: this.entry ? this.entry.time_of_day.en : "",
                    zh: this.entry ? this.entry.time_of_day.zh : "",
                },
                item: {
                    en: this.entry ? this.entry.item.en : "",
                    zh: this.entry ? this.entry.item.zh : "",
                },
                location: {
                    en: this.entry ? this.entry.location.en : "",
                    zh: this.entry ? this.entry.location.zh : "",
                },
            },
        };
    },

    computed: {
        incomplete() {
            return (
                (this.formData.time_of_day.en === "" &&
                    this.formData.time_of_day.zh === "") ||
                (this.formData.item.en === "" && this.formData.item.zh === "")
            );
        },
    },

    methods: {
        done() {
            if (this.formData.time_of_day.en === "") {
                this.formData.time_of_day.en = this.formData.time_of_day.zh;
            }

            if (this.formData.time_of_day.zh === "") {
                this.formData.time_of_day.zh = this.formData.time_of_day.en;
            }

            this.$emit("updated", {
                day: this.dayNumber,
                time_of_day: this.formData.time_of_day,
                location: this.formData.location,
                item: this.formData.item,
            });

            if (!this.entry) {
                this.formData = {
                    time_of_day: {
                        en: this.entry ? this.entry.time_of_day.en : "",
                        zh: this.entry ? this.entry.time_of_day.zh : "",
                    },
                    item: {
                        en: this.entry ? this.entry.item.en : "",
                        zh: this.entry ? this.entry.item.zh : "",
                    },
                    location: {
                        en: this.entry ? this.entry.location.en : "",
                        zh: this.entry ? this.entry.location.zh : "",
                    },
                };
            }
            this.showModal = false;
        },
    },
};
</script>
