import axios from "axios";

export default {
    namespaced: true,

    state: {
        users: [],
    },

    getters: {
        sorted_users: state => {
                  return state.users.sort((a,b) => {
                      if(a.name > b.name) {
                          return 1;
                      }
                      if(a.name < b.name) {
                          return -1;
                      }
                      return 0;
                  });
        }
    },

    actions: {
        fetchUsers({state}) {
            return new Promise((resolve, reject) => {
                axios.get("/admin/users")
                    .then(({data}) => {
                        state.users = data;
                        resolve();
                    })
                    .catch(() => reject({message: 'Unable to fetch users list.'}));
            })
        },

        fetchUser({state, dispatch}, id) {
            const user = state.users.find(u => u.id == id);

            if(user) {
                return Promise.resolve(user);
            }

            return new Promise((resolve, reject) => {
                dispatch('fetchUsers')
                    .then(() => {
                        const new_user = state.users.find(u => u.id == id);
                        new_user ? resolve(new_user) : reject({message: 'No user found'});
                    })
                    .catch(() => reject({message: 'Error while finding users'}));
            });
        },

        addUser({dispatch}, formData) {
            return new Promise((resolve, reject) => {
                axios.post("/admin/users", formData)
                    .then(() => {
                        dispatch('fetchUsers');
                        resolve();
                    })
                    .catch(({response}) => reject(response));
            });
        },

        retire({dispatch, state}, user) {
            return new Promise((resolve, reject) => {
                axios.delete(`/admin/users/${user.id}`)
                    .then(() => {
                        dispatch('fetchUsers');
                        user.is_retired = true;
                        user.retired_date = 'right now';
                        resolve(user);
                    })
                    .catch(() => reject({message: 'Unable to retire user.'}));
            });
        }
    }
}