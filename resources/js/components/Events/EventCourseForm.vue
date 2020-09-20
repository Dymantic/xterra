<template>
    <form @submit.prevent="submit">
        <div class="my-6">
            <p class="font-bold">Name</p>
            <p class="my-2 text-gray-600">
                The name of course
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    label="English"
                    :error-msg="formErrors.name"
                    v-model="formData.name.en"
                ></input-field>
                <input-field
                    class="my-4"
                    label="Chinese"
                    v-model="formData.name.zh"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Distance</p>
            <p class="my-2 text-gray-600">
                The distance of the course, if applicable
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    label="English"
                    :error-msg="formErrors.distance"
                    v-model="formData.distance.en"
                ></input-field>
                <input-field
                    class="my-4"
                    label="Chinese"
                    v-model="formData.distance.zh"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Description</p>
            <p class="my-2 text-gray-600">
                A brief description of the course.
            </p>
            <div class="pl-6">
                <textarea-field
                    class="mb-4"
                    label="English"
                    :error-msg="formErrors.description"
                    v-model="formData.description.en"
                ></textarea-field>
                <textarea-field
                    class="my-4"
                    label="Chinese"
                    v-model="formData.description.zh"
                ></textarea-field>
            </div>
        </div>
        <div class="my-10">
            <submit-button :waiting="waiting">Save Course</submit-button>
        </div>
    </form>
</template>

<script type="text/babel">
import InputField from "../Forms/InputField";
import TextareaField from "../Forms/TextareaField";
import SubmitButton from "../Forms/SubmitButton";
import { clearValidationErrors, setValidationErrors } from "../../lib/forms";
import { notify } from "../Messaging/notify";

export default {
    components: {
        InputField,
        TextareaField,
        SubmitButton,
    },

    props: ["course"],

    data() {
        return {
            waiting: false,
            formData: {
                name: { en: "", zh: "" },
                distance: { en: "", zh: "" },
                description: { en: "", zh: "" },
            },
            formErrors: {
                name: "",
                distance: "",
                description: "",
            },
        };
    },

    mounted() {
        if (this.course) {
            this.formData = {
                name: {
                    en: this.course.name.en,
                    zh: this.course.name.zh,
                },
                distance: {
                    en: this.course.distance.en,
                    zh: this.course.distance.zh,
                },
                description: {
                    en: this.course.description.en,
                    zh: this.course.description.zh,
                },
            };
        }
    },

    methods: {
        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            const action = this.course
                ? "events/updateCourse"
                : "events/createCourse";
            const payload = !this.course
                ? {
                      event_id: this.$route.params.id,
                      formData: this.formData,
                  }
                : {
                      course_id: this.course.id,
                      formData: this.formData,
                  };

            this.$store
                .dispatch(action, payload)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        onSuccess() {
            if (!this.course) {
                this.formData = {
                    name: { en: "", zh: "" },
                    distance: { en: "", zh: "" },
                    description: { en: "", zh: "" },
                };
            }

            notify.success({ message: "Course saved" });
            this.$router.push(`/events/${this.$route.params.id}/edit/courses`);
        },

        onError({ status, data }) {
            if (status === 422) {
                this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                );
                return notify.warn({ message: "Some input was not valid" });
            }
            notify.error({ message: "Failed to save course." });
        },
    },
};
</script>
