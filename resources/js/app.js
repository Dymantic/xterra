window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Vue from "vue";
import Vuex from "vuex";
import VueRouter from "vue-router";

Vue.use(VueRouter);
Vue.use(Vuex);


//routes
import topRoutes from "./routes/top";
import userRoutes from "./routes/users";
import profileRoutes from "./routes/profile";

const routes = [
    ...topRoutes,
    ...userRoutes,
    ...profileRoutes
];

const router = new VueRouter({routes});

//stores
import profileModule from "./stores/profile";
import usersModule from "./stores/users";

const store = new Vuex.Store({
    modules: {
        profile: profileModule,
        users: usersModule
    }
});

//components
import Navbar from "./components/Base/Navbar";
import NotificationHub from "./components/Messaging/NotificationHub";
import {notify} from "./components/Messaging/notify";

const app = new Vue({
    components: {
        Navbar,
        NotificationHub,
    },

    el: '#app',
    router,
    store,

    mounted() {
        this.$store.dispatch('profile/fetchProfile').catch(notify.error);
        this.$store.dispatch('users/fetchUsers').catch(notify.error);
    }
});
