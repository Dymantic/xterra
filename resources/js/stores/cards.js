import {
    createContentCard,
    createContentCardFromArticle,
    createContentCardFromEvent,
    createContentCardFromPromotion,
    deleteContentCard,
    fetchContentCards,
    updateContentCard,
} from "../apis/cards";
import { notify } from "../components/Messaging/notify";

export default {
    namespaced: true,

    state: {
        all: [],
    },

    getters: {
        byId: (state) => (id) =>
            state.all.find((card) => card.id === parseInt(id)),
    },

    mutations: {
        setCards(state, cards) {
            state.all = cards;
        },
    },

    actions: {
        fetchAll({ dispatch, state }) {
            if (state.all.length) {
                return Promise.resolve();
            }
            return dispatch("refresh");
        },

        refresh({ commit }) {
            return fetchContentCards()
                .then((cards) => commit("setCards", cards))
                .catch(() =>
                    notify.error({ message: "Failed to fetch content cards" })
                );
        },

        create({ dispatch }, formData) {
            return createContentCard(formData).then(() => dispatch("refresh"));
        },

        update({ dispatch }, { card_id, formData }) {
            return updateContentCard(card_id, formData).then(() =>
                dispatch("refresh")
            );
        },

        delete({ dispatch }, card_id) {
            return deleteContentCard(card_id).then(() => dispatch("refresh"));
        },

        createFromArticle({ dispatch }, article_id) {
            return createContentCardFromArticle(article_id).then(() =>
                dispatch("refresh")
            );
        },

        createFromEvent({ dispatch }, event_id) {
            return createContentCardFromEvent(event_id).then(() =>
                dispatch("refresh")
            );
        },

        createFromPromotion({ dispatch }, promotion_id) {
            return createContentCardFromPromotion(promotion_id).then(() =>
                dispatch("refresh")
            );
        },
    },
};
