<template>
    <div class="my-12 p-8 max-w-2xl bg-white shadow-lg mx-auto">
        <div class="w-64 my-4 flex items-center">
            <svg class="bg-gray-200 text-gray-800 py-2"
                 xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 24 24"
                 width="40"
                 height="40">
                <path class="fill-current"
                      d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"/>
            </svg>
            <input type="text"
                   class="form-input"
                   placeholder="Search users"
                   v-model="query">
        </div>
        <div class="h-80 overflow-auto">
            <div v-for="user in filtered_users"
                 :key="user.id"
                 class="flex justify-between mb-2">
                <p class="text-gray-800 hover:text-blue-800 font-bold">
                    <router-link :to="`/users/${user.id}`">{{ user.name }}</router-link>
                </p>
                <p class="text-right text-gray-600 hover:text-blue-600">
                    <a target="_blank"
                       :href="`mailto:${user.email}`">{{ user.email }}</a>
                </p>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-between">
            <div class="flex items-center">
                <input class="mr-4" type="checkbox" id="show-retired" v-model="show_retired">
                <label for="show-retired">Show retired users?</label>
            </div>
            <router-link to="/users/create"
                         class="btn btn-dark">Add User
            </router-link>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {

        data() {
            return {
                query: '',
                show_retired: false,
            };
        },

        computed: {
            users() {
                return this.$store.getters['users/sorted_users'];
            },

            filtered_users() {
                return this.users.filter(u => {
                    if(u.is_retired && !this.show_retired) {
                        return false;
                    }

                    return u.name.toLowerCase().includes(this.query.toLowerCase());
                })
            }
        }
    }
</script>

