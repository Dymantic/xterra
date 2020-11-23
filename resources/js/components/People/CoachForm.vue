<template>
    <form @submit.prevent="submit" class="max-w-xl admin-edited">
        <div class="my-6">
            <p class="font-bold">Name</p>
            <p class="my-2 text-gray-600">The name of the coach</p>
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
            <p class="font-bold">Location</p>
            <p class="my-2 text-gray-600">
                Where is the coach based in Taiwan?
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    label="English"
                    :error-msg="formErrors.location"
                    v-model="formData.location.en"
                ></input-field>
                <input-field
                    class="my-4"
                    label="Chinese"
                    v-model="formData.location.zh"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Email</p>
            <p class="my-2 text-gray-600">
                An optional email address for people to get in touch.
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    :error-msg="formErrors.email"
                    v-model="formData.email"
                    type="email"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Phone Number</p>
            <p class="my-2 text-gray-600">
                An optional phone number for people to call
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    :error-msg="formErrors.phone"
                    v-model="formData.phone"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Website url</p>
            <p class="my-2 text-gray-600">
                An optional link to the coach's website
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    :error-msg="formErrors.website"
                    v-model="formData.website"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Line ID</p>
            <p class="my-2 text-gray-600">
                An optional Line ID for people to use
            </p>
            <div class="pl-6">
                <input-field
                    class="mb-4"
                    :error-msg="formErrors.line"
                    v-model="formData.line"
                ></input-field>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Certification</p>
            <p class="my-2 text-gray-600">
                Describe or list the coach's certification
            </p>
            <div class="pl-6 mt-6">
                <span class="text-sm font-bold">English</span>
                <p
                    v-show="formErrors.certifications"
                    class="text-sm text-red-600"
                >
                    {{ formErrors.certifications }}
                </p>
                <wysiwyg
                    class="mb-6"
                    v-model="formData.certifications.en"
                ></wysiwyg>
                <span class="text-sm font-bold">Chinese</span>
                <wysiwyg
                    class="mb-6"
                    v-model="formData.certifications.zh"
                ></wysiwyg>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">High Level Experience</p>
            <p class="my-2 text-gray-600">
                A write-up opf the coach's experience
            </p>
            <div class="pl-6 mt-6">
                <span class="text-sm font-bold">English</span>
                <p v-show="formErrors.experience" class="text-sm text-red-600">
                    {{ formErrors.experience }}
                </p>
                <wysiwyg
                    class="mb-6"
                    v-model="formData.experience.en"
                ></wysiwyg>
                <span class="text-sm font-bold">Chinese</span>
                <wysiwyg
                    class="mb-6"
                    v-model="formData.experience.zh"
                ></wysiwyg>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Philosophy</p>
            <p class="my-2 text-gray-600">The ambassador's philosophy</p>
            <div class="pl-6 mt-6">
                <span class="text-sm font-bold">English</span>
                <p v-show="formErrors.philosophy" class="text-sm text-red-600">
                    {{ formErrors.philosophy }}
                </p>
                <wysiwyg
                    class="mb-6"
                    v-model="formData.philosophy.en"
                ></wysiwyg>
                <span class="text-sm font-bold">Chinese</span>
                <wysiwyg
                    class="mb-6"
                    v-model="formData.philosophy.zh"
                ></wysiwyg>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold mb-8">Social links</p>
            <p class="text-gray-600 max-w-md">
                Add the full link, including the http(s):// part. Leave the
                field blank to not include a specific platform.
            </p>

            <input-field
                class="my-6"
                label="Facebook"
                v-model="formData.facebook"
            ></input-field>

            <input-field
                class="my-6"
                label="Instagram"
                v-model="formData.instagram"
            ></input-field>

            <input-field
                class="my-6"
                label="Linkdin"
                v-model="formData.linkdin"
            ></input-field>

            <input-field
                class="my-6"
                label="YouTube"
                v-model="formData.youtube"
            ></input-field>
        </div>

        <div class="my-6">
            <submit-button :waiting="waiting">Save Ambassador</submit-button>
        </div>
    </form>
</template>

<script type="text/babel">
import InputField from "../Forms/InputField";
import Wysiwyg from "@dymantic/vue-trix-editor";
import { clearValidationErrors, setValidationErrors } from "../../lib/forms";
import { notify } from "../Messaging/notify";
import SubmitButton from "../Forms/SubmitButton";
export default {
    components: { SubmitButton, InputField, Wysiwyg },

    props: ["coach"],

    data() {
        return {
            waiting: false,
            formData: {
                name: { en: "", zh: "" },
                location: { en: "", zh: "" },
                email: "",
                phone: "",
                website: "",
                line: "",
                certifications: { en: "", zh: "" },
                experience: { en: "", zh: "" },
                philosophy: { en: "", zh: "" },
                facebook: "",
                linkdin: "",
                youtube: "",
                instagram: "",
            },
            formErrors: {
                name: "",
                location: "",
                phone: "",
                email: "",
                website: "",
                line: "",
                certifications: "",
                experience: "",
                philosophy: "",
            },
        };
    },

    mounted() {
        if (this.coach) {
            this.formData = {
                name: {
                    en: this.coach.name.en,
                    zh: this.coach.name.zh,
                },
                location: {
                    en: this.coach.location.en,
                    zh: this.coach.location.zh,
                },
                email: this.coach.email,
                phone: this.coach.phone,
                website: this.coach.website,
                line: this.coach.line,
                certifications: {
                    en: this.coach.certifications.en,
                    zh: this.coach.certifications.zh,
                },
                experience: {
                    en: this.coach.experience.en,
                    zh: this.coach.experience.zh,
                },
                philosophy: {
                    en: this.coach.philosophy.en,
                    zh: this.coach.philosophy.zh,
                },
                facebook: this.getSocialLink("facebook"),
                instagram: this.getSocialLink("instagram"),
                linkdin: this.getSocialLink("linkdin"),
                youtube: this.getSocialLink("youtube"),
            };
        }
    },

    methods: {
        getSocialLink(platform) {
            const link = this.coach.social_links.find(
                (l) => l.platform === platform
            );
            return link ? link.link : "";
        },

        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            const action = this.coach ? "coaches/update" : "coaches/create";
            const payload = this.coach
                ? {
                      coach_id: this.coach.id,
                      formData: this.preppedData(),
                  }
                : this.preppedData();

            this.$store
                .dispatch(action, payload)
                .then(this.onSuccess)
                .catch(this.onError)
                .then(() => (this.waiting = false));
        },

        preppedData() {
            const data = {
                name: this.formData.name,
                location: this.formData.location,
                email: this.formData.email,
                phone: this.formData.phone,
                website: this.formData.website,
                line: this.formData.line,
                certifications: this.formData.certifications,
                experience: this.formData.experience,
                philosophy: this.formData.philosophy,
                social_links: [],
            };
            ["facebook", "instagram", "linkdin", "youtube"].forEach(
                (platform) => {
                    if (this.formData[platform]) {
                        data.social_links.push({
                            platform,
                            link: this.formData[platform],
                        });
                    }
                }
            );
            return data;
        },

        onSuccess(response) {
            console.log({ response });
            notify.success({ message: "Coach saved." });
            const id = this.coach ? this.coach.id : response.id;
            this.$router.push(`/coaches/${id}/show`);
        },

        onError({ status, data }) {
            if (status === 422) {
                return (this.formErrors = setValidationErrors(
                    this.formErrors,
                    data.errors
                ));
            }
            notify.error({ message: "Failed to save error" });
        },
    },
};
</script>

<style>
.dd-vue-trix trix-editor {
    background: white;
}
</style>
