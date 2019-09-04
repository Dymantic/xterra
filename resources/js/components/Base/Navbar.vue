<template>
    <div class="h-16 bg-gray-800 flex justify-between items-center px-4 text-white">
        <div>
            <router-link to="/">Xterra</router-link>
        </div>
        <div class="flex justify-end items-center">
            <router-link to="/users"
                         class="mr-4">Users
            </router-link>
            <dropdown-menu v-cloak
                           :name="user_name"
                           class="text-white h-12 flex items-center h-16">
                <div slot="dropdown_content"
                     class="pt-3">
                    <router-link to="/profile/edit"
                                 class="text-black no-underline hover:text-indigo-500 pb-3 block">Edit Profile
                    </router-link>
                    <router-link to="/profile/password"
                                 class="text-black no-underline hover:text-indigo-500 pb-3 block">Reset Password
                    </router-link>
                    <button class="text-gray-800 pb-3"
                            @click="logout">Logout
                    </button>
                </div>
            </dropdown-menu>
        </div>
    </div>
</template>

<script type="text/babel">
    import {Dropdown} from "@dymantic/vuetilities";

    export default {
        components: {
            "dropdown-menu": Dropdown,
        },

        computed: {
            user_name() {
                return this.$store.state.profile.name;
            }
        },

        methods: {
            logout() {
                this.$store.dispatch('profile/logout')
                    .then(() => window.location = '/');
            }
        }
    }
</script>

