<template>
    <div
        class="h-16 bg-gray-800 flex justify-between items-center px-4 text-white"
    >
        <div>
            <router-link to="/">
                <img src="/images/logos/nav_logo.svg" class="h-8" alt="" />
            </router-link>
        </div>
        <div class="flex justify-end items-center">
            <router-link to="/campaigns" class="mx-4">Campaigns </router-link>
            <router-link to="/events" class="mx-4">Events </router-link>

            <router-link to="/promotions" class="mx-4">Shop </router-link>

            <dropdown-menu
                v-cloak
                name="Content"
                class="text-white h-12 flex items-center h-16 mx-4"
            >
                <div slot="dropdown_content" class="pt-3">
                    <router-link
                        to="/homepage"
                        class="text-black no-underline hover:text-indigo-500 pb-3 block"
                        >Home Page
                    </router-link>
                    <router-link
                        to="/pages"
                        class="text-black no-underline hover:text-indigo-500 pb-3 block"
                        >Discover Pages
                    </router-link>
                    <router-link
                        to="/content-cards"
                        class="text-black no-underline hover:text-indigo-500 pb-3 block"
                        >Content Cards
                    </router-link>
                    <router-link
                        to="/galleries"
                        class="text-black no-underline hover:text-indigo-500 pb-3 block"
                        >Galleries
                    </router-link>
                    <router-link
                        to="/instagram"
                        class="text-black no-underline hover:text-indigo-500 pb-3 block"
                        >Instagram
                    </router-link>
                </div>
            </dropdown-menu>

            <dropdown-menu
                v-cloak
                name="Blog"
                class="text-white h-12 flex items-center h-16 mx-4"
            >
                <div slot="dropdown_content" class="pt-3">
                    <router-link
                        to="/articles"
                        class="text-black no-underline hover:text-indigo-500 pb-3 block"
                        >Articles
                    </router-link>
                    <router-link
                        to="/categories"
                        class="text-black no-underline hover:text-indigo-500 pb-3 block"
                        >Categories
                    </router-link>
                    <router-link
                        to="/tags"
                        class="text-black no-underline hover:text-indigo-500 pb-3 block"
                        >Tags
                    </router-link>
                    <router-link
                        to="/slider"
                        class="text-black no-underline hover:text-indigo-500 pb-3 block"
                        >Slider
                    </router-link>
                    <div
                        class="mt-2 text-gray-500 text-xs border-b border-gray-100 mb-2 uppercase"
                    >
                        Comments
                    </div>
                    <router-link
                        to="/comments-review"
                        class="text-black no-underline hover:text-indigo-500 pb-3 block"
                        >Review Recent
                    </router-link>
                    <router-link
                        to="/flagged-comments"
                        class="text-black no-underline hover:text-indigo-500 pb-3 block"
                        >Flagged
                    </router-link>
                </div>
            </dropdown-menu>

            <div class="w-1 h-12 border-l border-gray-500 mx-4"></div>
            <router-link to="/users" class="mr-4">Users </router-link>
            <svg
                class="fill-current text-gray-500 h-4 ml-4 mr-2"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
            >
                <path
                    d="M7.725 2.146c-1.016.756-1.289 1.953-1.239 2.59.064.779.222 1.793.222 1.793s-.313.17-.313.854c.109 1.717.683.976.801 1.729.284 1.814.933 1.491.933 2.481 0 1.649-.68 2.42-2.803 3.334C3.196 15.845 1 17 1 19v1h18v-1c0-2-2.197-3.155-4.328-4.072-2.123-.914-2.801-1.684-2.801-3.334 0-.99.647-.667.932-2.481.119-.753.692-.012.803-1.729 0-.684-.314-.854-.314-.854s.158-1.014.221-1.793c.065-.817-.398-2.561-2.3-3.096-.333-.34-.558-.881.466-1.424-2.24-.105-2.761 1.067-3.954 1.929z"
                />
            </svg>
            <dropdown-menu
                v-cloak
                :name="user_name"
                class="text-white h-12 flex items-center h-16"
            >
                <div slot="dropdown_content" class="pt-3">
                    <router-link
                        to="/profile/edit"
                        class="text-black no-underline hover:text-indigo-500 pb-3 block"
                        >Edit Profile
                    </router-link>
                    <router-link
                        to="/profile/password"
                        class="text-black no-underline hover:text-indigo-500 pb-3 block"
                        >Reset Password
                    </router-link>
                    <button class="text-gray-800 pb-3" @click="logout">
                        Logout
                    </button>
                </div>
            </dropdown-menu>
        </div>
    </div>
</template>

<script type="text/babel">
import { Dropdown } from "@dymantic/vuetilities";

export default {
    components: {
        "dropdown-menu": Dropdown,
    },

    computed: {
        user_name() {
            return this.$store.state.profile.name;
        },
    },

    methods: {
        logout() {
            this.$store
                .dispatch("profile/logout")
                .then(() => (window.location = "/"));
        },
    },
};
</script>
