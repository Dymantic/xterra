<template>
    <div class="max-w-lg mx-auto p-8 bg-white shadow-lg mt-20">
        <p class="text-xl font-bold text-gray-800">Reset Your Password</p>
        <p class="my-4">Reset your password to something only you know and you will remember. Your password needs to be at least 8 characters long.</p>
        <form @submit.prevent="submit">
            <div class="my-4" :class="{'border-b border-red-400': formErrors.current_password}">
                <label class="form-label" for="current_password">Current Password</label>
                <span class="text-xs text-red-400" v-show="formErrors.current_password">{{ formErrors.current_password }}</span>
                <input type="password" name="current_password" v-model="formData.current_password" class="form-input" id="current_password">
            </div>
            <div class="my-4" :class="{'border-b border-red-400': formErrors.password}">
                <label class="form-label" for="password">Password</label>
                <span class="text-xs text-red-400" v-show="formErrors.password">{{ formErrors.password }}</span>
                <input type="password" name="password" v-model="formData.password" class="form-input" id="password">
            </div>
            <div class="my-4">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" v-model="formData.password_confirmation" class="form-input" id="password_confirmation">
            </div>
            <div>
                <button type="submit" class="btn btn-dark" :disabled="waiting">Reset Password</button>
            </div>
        </form>
    </div>
</template>

<script type="text/babel">
    import {notify} from "../Messaging/notify";

    export default {
        data() {
            return {
                waiting: false,
                formData: {
                    current_password: '',
                    password: '',
                    password_confirmation: ''
                },
                formErrors: {
                    current_password: '',
                    password: '',
                }
            };
        },

        methods: {
            submit() {
                this.waiting = true;
                this.clearFormErrors();
                this.$store.dispatch('profile/resetPassword', this.formData)
                    .then(this.onPasswordReset)
                    .catch(this.onPasswordResetError)
                    .then(() => this.waiting = false);
            },

            onPasswordReset() {
                this.clearFormData();
                this.clearFormErrors();
                notify.success({message: 'Your password has been successfully updated.'})
            },

            onPasswordResetError({status, data}) {
                if(status === 422) {
                    Object.keys(data.errors).forEach(key => {
                        this.formErrors[key] = data.errors[key][0];
                    });
                    return notify.warn({message: 'Some of your input is not valid.'});
                }

                notify.error({message: 'Unable to update your password right now.'})
            },

            clearFormData() {
                this.formData = {
                    current_password: '',
                    password: '',
                    password_confirmation: ''
                };
            },

            clearFormErrors() {
                this.formErrors = {
                    current_password: '',
                    password: '',
                };
            }
        }
    }
</script>

