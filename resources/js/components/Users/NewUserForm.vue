<template>
    <div class="max-w-lg mx-auto p-8 shadow-lg">
        <form autocomplete="off"
              @submit.prevent="submit">
            <p class="text-xl font-bold text-gray-800">Add a new member to the team</p>
            <div class="my-4"
                 :class="{'border-b border-red-400': formErrors.name}">
                <label class="form-label"
                       for="name">Name</label>
                <span class="text-xs text-red-400"
                      v-show="formErrors.name">{{ formErrors.name }}</span>
                <input type="text"
                       name="name"
                       v-model="formData.name"
                       class="form-input"
                       id="name">
            </div>
            <div class="my-4"
                 :class="{'border-b border-red-400': formErrors.email}">
                <label class="form-label"
                       for="email">Email</label>
                <span class="text-xs text-red-400"
                      v-show="formErrors.email">{{ formErrors.email }}</span>
                <input type="email"
                       name="email"
                       v-model="formData.email"
                       class="form-input"
                       id="email">
            </div>
            <p class="mt-8 mb-2 text-sm">Passwords have already been suggested, but you are welcome to change to whatever you want.</p>
            <div class="my-4"
                 :class="{'border-b border-red-400': formErrors.password}">
                <label class="form-label"
                       for="password">Password</label>
                <span class="text-xs text-red-400"
                      v-show="formErrors.password">{{ formErrors.password }}</span>
                <input type="password"
                       name="password"
                       autocomplete="new-password"
                       v-model="formData.password"
                       class="form-input"
                       id="password">
                <div class="my-4"
                     :class="{'border-b border-red-400': formErrors.password_confirmation}">
                    <label class="form-label"
                           for="password_confirmation">Password_confirmation</label>
                    <span class="text-xs text-red-400"
                          v-show="formErrors.password_confirmation">{{ formErrors.password_confirmation }}</span>
                    <input type="password"
                           name="password_confirmation"
                           v-model="formData.password_confirmation"
                           class="form-input"
                           id="password_confirmation">
                </div>
            </div>
            <div class="flex justify-end mt-8">
                <router-link to="/users" class="text-gray-600 hover:text-blue-600 mr-4">Cancel</router-link>
                <button class="btn btn-dark" :disabled="waiting" type="submit">Create User</button>
            </div>
        </form>
    </div>
</template>

<script type="text/babel">
    import {suggestPassword} from "../../lib/suggest-password";
    import {notify} from "../Messaging/notify";

    export default {
        data() {
            return {
                waiting: false,
                formData: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                formErrors: {
                    name: '',
                    email: '',
                    password: '',
                }
            };
        },

        mounted() {
            this.setSuggestedPasswords();
        },

        methods: {

            submit() {
                this.clearFormErrors();
                this.waiting = true;
                this.$store.dispatch('users/addUser', this.formData)
                    .then(this.onSubmitted)
                    .catch(this.onSubmitError)
                    .then(() => this.waiting = false);
            },

            onSubmitted() {
                notify.success({message: `${this.formData.name} has been added to the team, and will be notified`});
                this.clearFormData();
                this.setSuggestedPasswords();
                this.$router.push('/users');
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

            clearForm() {
                this.clearFormErrors();
                this.clearFormData();
                this.setSuggestedPasswords();
            },

            clearFormData() {
                this.formData = {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                };
            },

            clearFormErrors() {
                this.formErrors = {
                    name: '',
                    email: '',
                    password: '',
                };
            },

            setSuggestedPasswords() {
                const pwd = suggestPassword();
                this.formData.password = pwd;
                this.formData.password_confirmation = pwd;
            },
        }
    }
</script>

