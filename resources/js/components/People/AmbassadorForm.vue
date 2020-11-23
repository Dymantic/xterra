<template>
    <form @submit.prevent="submit" class="max-w-xl admin-edited">
        <div class="my-6">
            <p class="font-bold">Name</p>
            <p class="my-2 text-gray-600">The name of the ambassador</p>
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
            <p class="font-bold">About</p>
            <p class="my-2 text-gray-600">
                A brief introduction for this person
            </p>
            <div class="pl-6 mt-6">
                <span class="text-sm font-bold">English</span>
                <p v-show="formErrors.about" class="text-sm text-red-600">
                    {{ formErrors.about }}
                </p>
                <wysiwyg class="mb-6" v-model="formData.about.en"></wysiwyg>
                <span class="text-sm font-bold">Chinese</span>
                <wysiwyg class="mb-6" v-model="formData.about.zh"></wysiwyg>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Achievements</p>
            <p class="my-2 text-gray-600">
                A list of the ambassador's achievements.
            </p>
            <div class="pl-6 mt-6">
                <span class="text-sm font-bold">English</span>
                <p
                    v-show="formErrors.achievements"
                    class="text-sm text-red-600"
                >
                    {{ formErrors.achievements }}
                </p>
                <wysiwyg
                    class="mb-6"
                    v-model="formData.achievements.en"
                ></wysiwyg>
                <span class="text-sm font-bold">Chinese</span>
                <wysiwyg
                    class="mb-6"
                    v-model="formData.achievements.zh"
                ></wysiwyg>
            </div>
        </div>

        <div class="my-6">
            <p class="font-bold">Work with XTERRA</p>
            <p class="my-2 text-gray-600">
                Describe the collaboration between the ambassador and XTERRA
            </p>
            <div class="pl-6 mt-6">
                <span class="text-sm font-bold">English</span>
                <p
                    v-show="formErrors.collaboration"
                    class="text-sm text-red-600"
                >
                    {{ formErrors.collaboration }}
                </p>
                <wysiwyg
                    class="mb-6"
                    v-model="formData.collaboration.en"
                ></wysiwyg>
                <span class="text-sm font-bold">Chinese</span>
                <wysiwyg
                    class="mb-6"
                    v-model="formData.collaboration.zh"
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

    props: ["ambassador"],

    data() {
        return {
            waiting: false,
            formData: {
                name: { en: "", zh: "" },
                about: { en: "", zh: "" },
                achievements: { en: "", zh: "" },
                collaboration: { en: "", zh: "" },
                philosophy: { en: "", zh: "" },
                facebook: "",
                linkdin: "",
                youtube: "",
                instagram: "",
            },
            formErrors: {
                name: "",
                about: "",
                achievements: "",
                collaboration: "",
                philosophy: "",
            },
        };
    },

    mounted() {
        if (this.ambassador) {
            const social_links = ["facebook", ""];
            this.formData = {
                name: {
                    en: this.ambassador.name.en,
                    zh: this.ambassador.name.zh,
                },
                about: {
                    en: this.ambassador.about.en,
                    zh: this.ambassador.about.zh,
                },
                achievements: {
                    en: this.ambassador.achievements.en,
                    zh: this.ambassador.achievements.zh,
                },
                collaboration: {
                    en: this.ambassador.collaboration.en,
                    zh: this.ambassador.collaboration.zh,
                },
                philosophy: {
                    en: this.ambassador.philosophy.en,
                    zh: this.ambassador.philosophy.zh,
                },
                facebook: this.getSocialLink(
                    "facebook",
                    this.ambassador.social_links
                ),
                instagram: this.getSocialLink(
                    "instagram",
                    this.ambassador.social_links
                ),
                linkdin: this.getSocialLink(
                    "linkdin",
                    this.ambassador.social_links
                ),
                youtube: this.getSocialLink(
                    "youtube",
                    this.ambassador.social_links
                ),
            };
        }
    },

    methods: {
        getSocialLink(platform, links) {
            const link = links.find((l) => l.platform === platform);
            return link ? link.link : "";
        },

        submit() {
            this.waiting = true;
            this.formErrors = clearValidationErrors(this.formErrors);

            const action = this.ambassador
                ? "ambassadors/update"
                : "ambassadors/create";
            const payload = this.ambassador
                ? {
                      ambassador_id: this.ambassador.id,
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
                about: this.formData.about,
                achievements: this.formData.achievements,
                collaboration: this.formData.collaboration,
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
            notify.success({ message: "Ambassador saved." });
            const id = this.ambassador ? this.ambassador.id : response.id;
            this.$router.push(`/ambassadors/${id}/show`);
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
