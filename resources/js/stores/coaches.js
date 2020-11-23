import { notify } from "../components/Messaging/notify";
import {
    attachCoachVideo,
    createCoach,
    deleteCoach,
    getCoaches,
    publishCoach,
    retractCoach,
    updateCoach,
} from "../apis/people";

export default {
    namespaced: true,

    state: {
        all: [],
    },

    getters: {
        byId: (state) => (id) =>
            state.all.find((coach) => coach.id === parseInt(id)),
    },

    mutations: {
        setCoaches(state, coaches) {
            state.all = coaches;
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
            return getCoaches()
                .then((coaches) => commit("setCoaches", coaches))
                .catch(() =>
                    notify.error({ message: "Failed to fetch coaches." })
                );
        },

        create({ dispatch }, formData) {
            return createCoach(formData).then((coach) => {
                dispatch("refresh");
                return coach;
            });
        },

        update({ dispatch }, { coach_id, formData }) {
            return updateCoach(coach_id, formData).then(() =>
                dispatch("refresh")
            );
        },

        delete({ dispatch }, coach_id) {
            return deleteCoach(coach_id).then(() => dispatch("refresh"));
        },

        attachVideo({ dispatch }, { coach_id, formData }) {
            return attachCoachVideo(coach_id, formData).then(() =>
                dispatch("refresh")
            );
        },

        publish({ dispatch }, coach_id) {
            return publishCoach(coach_id).then(() => dispatch("refresh"));
        },

        retract({ dispatch }, coach_id) {
            return retractCoach(coach_id).then(() => dispatch("refresh"));
        },
    },
};
