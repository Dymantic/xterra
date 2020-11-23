import {
    attachAmbassadorVideo,
    createAmbassador,
    deleteAmbassador,
    getAmbassadors,
    publishAmbassador,
    retractAmbassador,
    updateAmbassador,
} from "../apis/people";
import { notify } from "../components/Messaging/notify";

export default {
    namespaced: true,

    state: {
        all: [],
    },

    getters: {
        byId: (state) => (id) =>
            state.all.find((amb) => amb.id === parseInt(id)),
    },

    mutations: {
        setAmbassadors(state, ambassadors) {
            state.all = ambassadors;
        },
    },

    actions: {
        fetch({ state, dispatch }) {
            if (state.all.length) {
                return Promise.resolve();
            }
            return dispatch("refresh");
        },

        refresh({ commit }) {
            return getAmbassadors()
                .then((ambassadors) => commit("setAmbassadors", ambassadors))
                .catch(() =>
                    notify.error({ message: "Failed to fetch ambassadors." })
                );
        },

        create({ dispatch }, formData) {
            return createAmbassador(formData).then((ambassador) => {
                dispatch("refresh");
                return ambassador;
            });
        },

        update({ dispatch }, { ambassador_id, formData }) {
            return updateAmbassador(ambassador_id, formData).then(() =>
                dispatch("refresh")
            );
        },

        delete({ dispatch }, ambassador_id) {
            return deleteAmbassador(ambassador_id).then(() =>
                dispatch("refresh")
            );
        },

        attachVideo({ dispatch }, { ambassador_id, formData }) {
            return attachAmbassadorVideo(ambassador_id, formData).then(() =>
                dispatch("refresh")
            );
        },

        publish({ dispatch }, ambassador_id) {
            return publishAmbassador(ambassador_id).then(() =>
                dispatch("refresh")
            );
        },

        retract({ dispatch }, ambassador_id) {
            return retractAmbassador(ambassador_id).then(() =>
                dispatch("refresh")
            );
        },
    },
};
