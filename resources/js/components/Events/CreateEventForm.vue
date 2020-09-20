<template>
    <span>
        <button @click="showForm = true" class="btn btn-dark">
            Create New Event
        </button>
        <modal :show="showForm" @close="showForm = false">
            <div class="w-screen max-w-lg p-6">
                <p class="text-lg font-bold mb-6">Create a new XTRERRA event</p>
                <p class="text-gray-600">
                    Provide a name in at least one language to get started.
                </p>
                <form @submit.prevent="submit">
                    <input-field
                        class="my-4"
                        label="Name (English)"
                        v-model="formData.name.en"
                        :error-msg="formErrors['name.en']"
                    ></input-field>
                    <input-field
                        class="my-4"
                        label="Name (Chinese)"
                        v-model="formData.name.zh"
                        :error-msg="formErrors['name.zh']"
                    ></input-field>
                    <div class="flex justify-end mt-6">
                        <button type="button" @click="showForm = false">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-dark ml-4">
                            Create Event
                        </button>
                    </div>
                </form>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
import InputField from "../Forms/InputField";
import { clearValidationErrors, setValidationErrors } from "../../lib/forms";
import { notify } from "../Messaging/notify";
export default {
    components: {
        InputField,
    },

    data() {
        return {
            showForm: false,
            formData: {
                name: { en: "", zh: "" },
            },
            formErrors: {
                "name.en": "",
                "name.zh": "",
            },
        };
    },

    methods: {
        submit() {
            this.formErrors = clearValidationErrors(this.formErrors);
            this.$store
                .dispatch("events/createNew", this.formData)
                .then(this.onSuccess)
                .catch(this.onError);
        },

        onSuccess() {
            this.formData = {
                name: { en: "", zh: "" },
            };
            this.showForm = false;
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }
            notify.error({ message: "Failed to create event." });
        },
    },
};
</script>
