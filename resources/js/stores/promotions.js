import {
    createPromotion,
    deletePromotion,
    fetchPromotions,
    updatePromotion,
} from "../apis/promotions";

export default {
    namespaced: true,

    state: {
        all: [],
    },

    getters: {
        byId: (state) => (id) =>
            state.all.find((promo) => promo.id === parseInt(id)),
    },

    mutations: {
        setPromotions(state, promotions) {
            state.all = promotions;
        },
    },

    actions: {
        fetchAll({ state, dispatch }) {
            return new Promise((resolve, reject) => {
                if (state.all.length) {
                    return resolve();
                }

                dispatch("refresh").then(resolve).catch(reject);
            });
        },

        refresh({ commit }) {
            return fetchPromotions().then((promotions) =>
                commit("setPromotions", promotions)
            );
        },

        create({ dispatch }, formData) {
            return createPromotion(formData).then((promotion) => {
                dispatch("refresh");
                return promotion;
            });
        },

        update({ dispatch }, { promo_id, formData }) {
            return updatePromotion(promo_id, formData).then(() =>
                dispatch("refresh")
            );
        },

        delete({ dispatch }, promo_id) {
            return deletePromotion(promo_id).then(() => dispatch("refresh"));
        },
    },
};
