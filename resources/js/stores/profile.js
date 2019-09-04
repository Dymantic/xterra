import axios from "axios";

export default {
    namespaced: true,

    state: {
        name: '',
        email: '',
        fetched: false,
    },

    actions: {
        fetchProfile({state}) {
            return new Promise((resolve, reject) => {
                axios.get("/admin/me")
                     .then(({data}) => {
                         state.name = data.name;
                         state.email = data.email;
                         state.fetched = true;
                         resolve();
                     })
                     .catch(() => {
                         reject(() => {message: 'Unable to fetch profile'});
                     });
            });
        },

        logout() {
            return axios.post("/admin/logout");
        },

        update({state}, {name, email}) {
            return new Promise((resolve, reject) => {
                axios.post("/admin/me", {name, email})
                     .then(({data}) => {
                         state.name = data.name;
                         state.email = data.email;
                         resolve();
                     })
                     .catch(({response}) => reject(response));
            });
        },

        resetPassword({}, formData) {
            return new Promise((resolve, reject) => {
                axios.post("/admin/me/password", formData)
                     .then(() => resolve())
                     .catch(({response}) => reject(response));
            });
        }
    }
}