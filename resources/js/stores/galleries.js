import {
    createNewGallery,
    deleteGallery,
    fetchAllGalleries,
    setGalleryImageOrder,
    updateGallery,
} from "../apis/media";
import { notify } from "../components/Messaging/notify";

export default {
    namespaced: true,

    state: {
        all: [],
    },

    getters: {
        byId: (state) => (id) =>
            state.all.find((gallery) => gallery.id === parseInt(id)),
    },

    mutations: {
        setGalleries(state, galleries) {
            state.all = galleries;
        },
    },

    actions: {
        fetchGalleries({ dispatch, state }) {
            return new Promise((resolve, reject) => {
                if (state.all.length) {
                    return resolve();
                }

                dispatch("refreshGalleries").then(resolve).catch(reject);
            });
        },

        refreshGalleries({ commit }) {
            return fetchAllGalleries()
                .then((galleries) => commit("setGalleries", galleries))
                .catch(() =>
                    notify.error({ message: "Failed to fetch galleries" })
                );
        },

        create({ dispatch }, formData) {
            return createNewGallery(formData).then((gallery) => {
                dispatch("refreshGalleries");
                return gallery;
            });
        },

        update({ dispatch }, { gallery_id, formData }) {
            return updateGallery(gallery_id, formData).then(() =>
                dispatch("refreshGalleries")
            );
        },

        delete({ dispatch }, gallery_id) {
            return deleteGallery(gallery_id).then(() =>
                dispatch("refreshGalleries")
            );
        },

        setImageOrder({ dispatch }, { gallery_id, formData }) {
            return setGalleryImageOrder(gallery_id, formData).then(() =>
                dispatch("refreshGalleries")
            );
        },
    },
};
