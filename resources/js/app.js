import axios from "axios";
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import Vue from "vue";
import Vuex from "vuex";
import VueRouter from "vue-router";

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.config.ignoredElements = ["trix-editor"];

import Page from "./components/Page";
import PageHeader from "./components/PageHeader";
import Modal from "@dymantic/modal";
//universal components
Vue.component("modal", Modal);
Vue.component("page", Page);
Vue.component("page-header", PageHeader);

//routes
import userRoutes from "./routes/users";
import profileRoutes from "./routes/profile";
import blogRoutes from "./routes/articles";
import sliderRoutes from "./routes/slider";
import commentRoutes from "./routes/comments";
import eventRoutes from "./routes/events";
import mediaRoutes from "./routes/media";
import promotionRoutes from "./routes/promotions";
import campaignRoutes from "./routes/campaigns";
import cardRoutes from "./routes/cards";
import homePageRoutes from "./routes/homepage";

const routes = [
    ...userRoutes,
    ...profileRoutes,
    ...blogRoutes,
    ...sliderRoutes,
    ...commentRoutes,
    ...eventRoutes,
    ...mediaRoutes,
    ...promotionRoutes,
    ...campaignRoutes,
    ...cardRoutes,
    ...homePageRoutes,
];

const router = new VueRouter({
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return { x: 0, y: 0 };
        }
    },
});

//stores
import profileModule from "./stores/profile";
import usersModule from "./stores/users";
import articlesModule from "./stores/articles";
import sliderModule from "./stores/slider";
import commentsModule from "./stores/comments";
import eventsModule from "./stores/events";
import galleriesModule from "./stores/galleries";
import promotionsModule from "./stores/promotions";
import campaignsModule from "./stores/campaigns";
import cardsModule from "./stores/cards";
import homepageModule from "./stores/homepage";

const store = new Vuex.Store({
    modules: {
        profile: profileModule,
        users: usersModule,
        articles: articlesModule,
        slider: sliderModule,
        comments: commentsModule,
        events: eventsModule,
        galleries: galleriesModule,
        promotions: promotionsModule,
        campaigns: campaignsModule,
        cards: cardsModule,
        homepage: homepageModule,
    },
});

//components
import Navbar from "./components/Base/Navbar";
import NotificationHub from "./components/Messaging/NotificationHub";
import { notify } from "./components/Messaging/notify";

const app = new Vue({
    components: {
        Navbar,
        NotificationHub,
    },

    el: "#app",
    router,
    store,

    mounted() {
        this.$store.dispatch("profile/fetchProfile").catch(notify.error);
        this.$store.dispatch("users/fetchUsers").catch(notify.error);
        this.$store.dispatch("articles/fetchAll").catch(notify.error);
        this.$store.dispatch("articles/fetchCategories").catch(notify.error);
        this.$store.dispatch("articles/fetchAllTags").catch(notify.error);
        this.$store.dispatch("slider/fetch").catch(notify.error);
        this.$store.dispatch("comments/hydrate");
    },
});
