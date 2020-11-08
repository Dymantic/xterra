import {
    createPage,
    deletePage,
    getPages,
    publishPage,
    retractPage,
    updatePage,
    updatePageContents,
} from "../apis/pages";
import { notify } from "../components/Messaging/notify";

export default {
    namespaced: true,

    state: {
        all: [],
    },

    getters: {
        byId: (state) => (id) =>
            state.all.find((page) => page.id === parseInt(id)),
    },

    mutations: {
        setPages(state, pages) {
            state.all = pages;
        },
    },

    actions: {
        fetch({ state, dispatch }) {
            if (!state.all.length) {
                return dispatch("refresh");
            }

            return Promise.resolve();
        },

        refresh({ commit }) {
            return getPages()
                .then((pages) => commit("setPages", pages))
                .catch(() =>
                    notify.error({ message: "Failed to fetch pages" })
                );
        },

        create({ dispatch }, formData) {
            return createPage(formData).then(() => dispatch("refresh"));
        },

        update({ dispatch }, { page_id, formData }) {
            return updatePage(page_id, formData).then(() =>
                dispatch("refresh")
            );
        },

        updateContent({ dispatch }, { page_id, content, lang }) {
            return updatePageContents(page_id, content, lang).then(() =>
                dispatch("refresh")
            );
        },

        delete({ dispatch }, page_id) {
            return deletePage(page_id).then(() => dispatch("refresh"));
        },

        publish({ dispatch }, page_id) {
            return publishPage(page_id).then(() => dispatch("refresh"));
        },

        retract({ dispatch }, page_id) {
            return retractPage(page_id).then(() => dispatch("refresh"));
        },
    },
};
