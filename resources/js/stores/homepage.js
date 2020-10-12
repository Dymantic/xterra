import {
    attachHomePageCampaign,
    attachHomePageEvent,
    attachHomePagePromotion,
    attachHomePagePromoVideo,
    clearHomePagePromoVideo,
    fetchHomePageInfo,
    updateHomePageBannerText,
} from "../apis/homepage";
import { notify } from "../components/Messaging/notify";

export default {
    namespaced: true,

    state: {
        homepage: null,
    },

    mutations: {
        setMainState(state, homepage) {
            state.homepage = homepage;
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

        updateBannerText({ dispatch }, formData) {
            return updateHomePageBannerText(formData).then(() =>
                dispatch("refreshHomePage")
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

        attachPromoVideo({ dispatch }, formData) {
            return attachHomePagePromoVideo(formData).then(() =>
                dispatch("refreshHomePage")
            );
        },

        clearPromoVideo({ dispatch }) {
            return clearHomePagePromoVideo().then(() =>
                dispatch("refreshHomePage")
            );
        },
    },
};
