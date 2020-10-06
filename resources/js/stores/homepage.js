import {
    attachHomePageCampaign,
    attachHomePageEvent,
    attachHomePagePromotion,
    fetchHomePageInfo,
} from "../apis/homepage";
import { notify } from "../components/Messaging/notify";

export default {
    namespaced: true,

    state: {
        banner_image: {
            small: "",
            full: "",
        },
        event: null,
        campaign: null,
        promotion: null,
    },

    mutations: {
        setMainState(state, homepage) {
            state.banner_image = homepage.banner_image;
            state.event = homepage.event;
            state.campaign = homepage.campaign;
            state.promotion = homepage.promotion;
        },
    },

    actions: {
        fetchHomePage({ commit }) {
            return fetchHomePageInfo().then((homepage) =>
                commit("setMainState", homepage)
            );
        },

        refreshHomePage({ commit }) {
            return fetchHomePageInfo()
                .then((homepage) => commit("setMainState", homepage))
                .catch(() =>
                    notify.error({ message: "Error fetching homepage info." })
                );
        },

        attachPromotion({ dispatch }, promotion_id) {
            return attachHomePagePromotion(promotion_id).then(() =>
                dispatch("refreshHomePage")
            );
        },

        attachEvent({ dispatch }, event_id) {
            return attachHomePageEvent(event_id).then(() =>
                dispatch("refreshHomePage")
            );
        },

        attachCampaign({ dispatch }, campaign_id) {
            return attachHomePageCampaign(campaign_id).then(() =>
                dispatch("refreshHomePage")
            );
        },
    },
};
