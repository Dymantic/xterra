import { getInstagramFeed } from "../apis/instagram";

export default {
    namespaced: true,

    state: {
        has_auth: false,
        feed: [],
        auth_url: "",
    },

    mutations: {
        setInstagramState(state, instagram) {
            state.has_auth = instagram.has_auth;
            state.feed = instagram.feed;
            state.auth_url = instagram.auth_url;
        },
    },

    actions: {
        fetchInstagram({ commit }) {
            return getInstagramFeed().then((ig) =>
                commit("setInstagramState", ig)
            );
        },
    },
};
