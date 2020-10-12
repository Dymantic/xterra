import {
    assignArticleToCampaign,
    attachCampaignPromoVideo,
    clearCampaignPromoVideo,
    createCampaign,
    deleteCampaign,
    fetchCampaigns,
    removeArticleFromCampaign,
    updateCampaign,
    updateCampaignEvent,
    updateCampaignNarrative,
    updateCampaignPromotion,
} from "../apis/campaigns";
import { notify } from "../components/Messaging/notify";

export default {
    namespaced: true,

    state: {
        all: [],
    },

    getters: {
        byId: (state) => (id) =>
            state.all.find((campaign) => campaign.id === parseInt(id)),
    },

    mutations: {
        setCampaigns(state, campaigns) {
            state.all = campaigns;
        },
    },

    actions: {
        fetchAll({ dispatch, state }) {
            if (!state.all.length) {
                return dispatch("refresh");
            }
        },

        refresh({ commit }) {
            return fetchCampaigns()
                .then((campaigns) => commit("setCampaigns", campaigns))
                .catch(() =>
                    notify.error({ message: "Unable to fetch campaigns." })
                );
        },

        create({ dispatch }, formData) {
            return createCampaign(formData).then(() => dispatch("refresh"));
        },

        delete({ dispatch }, campaign_id) {
            return deleteCampaign(campaign_id).then(() => dispatch("refresh"));
        },

        update({ dispatch }, { campaign_id, formData }) {
            return updateCampaign(campaign_id, formData).then(() =>
                dispatch("refresh")
            );
        },

        updateNarrative({ dispatch }, { campaign_id, formData }) {
            return updateCampaignNarrative(campaign_id, formData).then(() =>
                dispatch("refresh")
            );
        },

        assignArticle({ dispatch }, { campaign_id, article_id }) {
            return assignArticleToCampaign(campaign_id, article_id).then(() =>
                dispatch("refresh")
            );
        },

        removeArticle({ dispatch }, { campaign_id, article_id }) {
            return removeArticleFromCampaign(campaign_id, article_id).then(() =>
                dispatch("refresh")
            );
        },

        setEvent({ dispatch }, { campaign_id, event_id }) {
            return updateCampaignEvent(campaign_id, event_id).then(() =>
                dispatch("refresh")
            );
        },

        setPromotion({ dispatch }, { campaign_id, promotion_id }) {
            return updateCampaignPromotion(campaign_id, promotion_id).then(() =>
                dispatch("refresh")
            );
        },

        attachPromoVideo({ dispatch }, { campaign_id, formData }) {
            return attachCampaignPromoVideo(campaign_id, formData).then(() =>
                dispatch("refresh")
            );
        },

        clearPromoVideo({ dispatch }, campaign_id) {
            return clearCampaignPromoVideo(campaign_id).then(() =>
                dispatch("refresh")
            );
        },
    },
};
