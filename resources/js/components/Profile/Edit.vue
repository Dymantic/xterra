<template>
    <div>
        <div v-if="ready" class="max-w-lg mx-auto p-8 bg-white shadow-lg mt-20">
            <p class="text-xl font-bold text-gray-800">Edit your Information</p>
            <p class="my-4 text-sm text-gray-600">Note that the email you have on record here is the one that will be used to log in, as well as to receive correspondence from the site.</p>
            <form @submit.prevent="submit">
                <div class="my-4" :class="{'border-b border-red-400': formErrors.name}">
                    <label class="form-label" for="name">Name</label>
                    <span class="text-xs text-red-400" v-show="formErrors.name">{{ formErrors.name }}</span>
                    <input type="text" name="name" v-model="formData.name" class="form-input" id="name">
                </div>
                <div class="my-4" :class="{'border-b border-red-400': formErrors.email}">
                    <label class="form-label" for="email">Email</label>
                    <span class="text-xs text-red-400" v-show="formErrors.email">{{ formErrors.email }}</span>
                    <input type="email" name="email" v-model="formData.email" class="form-input" id="email">
                </div>
                <div class="pt-4">
                    <button type="submit" class="btn btn-dark" :disabled="waiting">Update Profile</button>
                </div>
            </form>
        </div>
        <div v-else class="text-2xl mt-20 text-gray-600 text-center">Hold on a moment...</div>
    </div>


</template>

<script type="text/babel">
    import {notify} from "../Messaging/notify";

    export default {
        data() {
            return {
                ready: false,
                waiting: false,
                formData: {
                    name: '',
                    email: ''
                },
                formErrors: {
                    name: '',
                    email: ''
                }
            };
        },

        computed: {
            profile_fetched() {
                return this.$store.state.profile.fetched;
            }
        },

        watch: {
            profile_fetched(fetched) {
                if(fetched && (!this.ready)) {
                    this.setFormData();
                }
            }
        },

        mounted() {
            if(this.profile_fetched && (!this.ready)) {
                this.setFormData();
            }
        },

        methods: {
            setFormData() {
                this.formData.name = this.$store.state.profile.name;
                this.formData.email = this.$store.state.profile.email;
                this.ready = true;
            },

            submit() {
                this.clearFormErrors();
                this.waiting = true;
                this.$store.dispatch('profile/update', this.formData)
                    .then(this.onSubmitted)
                    .catch(this.onSubmitError)
                    .then(() => this.waiting = false);
            },

            onSubmitted() {
                notify.success({message: "Your information has been updated"});
                this.setFormData();
            },

            onSubmitError({status, data}) {
                if(status === 422) {
                    Object.keys(data.errors).forEach(key => {
                        this.formErrors[key] = data.errors[key][0];
                    });
                    return notify.warn({message: 'Some of your input is not valid.'});
                }

                notify.error({message: 'Unable to update your password right now.'});
            },

            clearFormErrors() {
                this.formErrors = {
                    name: '',
                    email: '',
                }
            }
        }
    }
</script>

