import axios from "axios";
import {notify} from "../components/Messaging/notify";

export default {

    namespaced: true,

    state: {
        articles: [],
        categories: [],
        tags: [],
    },

    getters: {
        article: state => id => {
            return state.articles.find(art => parseInt(art.id) === id);
        },

        categoryById: state => id => state.categories.find(cat => parseInt(cat.id) === parseInt(id)),

        articlesByCategoryId: state => id => {
            return state.articles
                        .filter(art => art.categories.map(cat => cat.id).includes(parseInt(id)));
        },

        tagsByName: state => {
            return state.tags.sort((a,b) => {
                const nameA = a.tag_name.toUpperCase();
                const nameB = b.tag_name.toUpperCase();
                if(nameA < nameB) {
                    return -1;
                }

                if(nameA > nameB) {
                    return 1;
                }
                return 0;
            });
        },

        tagsByCount: state => state.tags.sort((a,b) => b.translations_count - a.translations_count),

        tagById: state => id => state.tags.find(tag => parseInt(tag.id) === parseInt(id)),
    },

    actions: {

        fetchAll({state}, page = 1) {

            return new Promise((resolve, reject) => {
                axios.get(`/admin/articles?page=${page}`)
                     .then(({data}) => {
                         state.articles = data;
                         resolve();
                     })
                     .catch(() => reject({message: `Unable to fetch page ${page} of articles`}));
            });
        },

        fetchArticle({state, dispatch}, id) {
            let article = state.articles.find(art => art.id == id);

            if (article) {
                return Promise.resolve(article);
            }

            return new Promise((resolve, reject) => {
                dispatch('fetchAll')
                    .then(() => {
                        article = state.articles.find(art => art.id == id);
                        if (article) {
                            resolve(article);
                        } else {
                            reject({message: `Article #${id} not found`});
                        }
                    })
                    .catch(() => reject({message: 'There was an error fetching articles.'}));
            });
        },

        fetchCategories({state}) {
            return new Promise((resolve, reject) => {
                axios.get("/admin/categories")
                     .then(({data}) => {
                         state.categories = data;
                         resolve();
                     })
                     .catch(() => reject({message: 'Unable to fetch categories'}));
            });
        },

        setCategories({state, dispatch}, {article_id, category_ids}) {
            return new Promise((resolve, reject) => {
                axios.post(`/admin/articles/${article_id}/categories`, {category_ids})
                     .then(() => {
                         resolve();
                     })
                     .catch(({response}) => reject(response));
            });
        },

        createArticle({state, dispatch}, formData) {
            return new Promise((resolve, reject) => {
                axios.post("/admin/articles", formData)
                     .then(({data}) => {
                         dispatch('fetchAll').catch(() => {
                         });
                         resolve(data);
                     })
                     .catch(({response}) => reject(response));
            });
        },

        getTranslationById({}, id) {
            return new Promise((resolve, reject) => {
                axios.get(`/admin/translations/${id}`)
                     .then(({data}) => resolve(data))
                     .catch(({response}) => reject(response));
            });
        },

        saveTranslation({}, {id, formData}) {
            return new Promise((resolve, reject) => {
                axios.post(`/admin/translations/${id}`, formData)
                     .then(() => resolve())
                     .catch(({response}) => reject(response));
            });
        },

        addTranslation({dispatch}, {article_id, lang, title}) {
            return new Promise((resolve, reject) => {
                axios.post(`/admin/articles/${article_id}/translations`, {lang, title})
                     .then(({data}) => {
                         dispatch('fetchAll').catch(() => {
                         });
                         resolve(data);
                     })
                     .catch(({response}) => reject(response));
            });
        },

        publishTranslation({dispatch}, formData) {
            return new Promise((resolve, reject) => {
                axios.post("/admin/published-translations", formData)
                     .then(({data}) => {
                         dispatch('fetchAll').catch(() => {
                         });
                         resolve(data);
                     })
                     .catch(({response}) => reject(response));
            });

        },

        retractTranslation({dispatch}, id) {
            return new Promise((resolve, reject) => {
                axios.delete(`/admin/published-translations/${id}`)
                     .then(({data}) => {
                         dispatch('fetchAll').catch(() => {
                         });
                         resolve(data);
                     })
                     .catch(({response}) => reject(response));
            });

        },

        addCategory({dispatch}, formData) {
            return new Promise((resolve, reject) => {
                axios.post("/admin/categories", formData)
                     .then(() => {
                         dispatch('fetchCategories').catch(() => {
                         });
                         resolve({message: 'Category has been successfully added.'});
                     })
                     .catch(({response}) => reject(response));
            })
        },

        updateCategory({dispatch}, {id, formData}) {
            return new Promise((resolve, reject) => {
                axios.post(`/admin/categories/${id}`, formData)
                     .then(() => {
                         dispatch('fetchCategories').catch(() => {
                         });
                         resolve({message: 'Category has been successfully updated.'});
                     })
                     .catch(({response}) => reject(response));
            })
        },

        removeCategory({dispatch}, id) {
            return new Promise((resolve, reject) => {
                axios.delete(`/admin/categories/${id}`)
                     .then(() => {
                         dispatch('fetchCategories');
                         resolve({message: 'Category has been removed.'});
                     })
                     .catch(() => reject());
            });
        },

        searchArticles({}, title) {
            return new Promise((resolve, reject) => {
                axios.get(`/admin/search/articles?query=${title}`)
                     .then(({data}) => resolve(data))
                     .catch(() => reject({message: 'Unable to search articles'}));
            });

        },

        fetchAllTags({state}) {
            return new Promise((resolve, reject) => {
               axios.get("/admin/tags")
                   .then(({data}) => {
                       state.tags = data;
                       resolve();
                   })
                   .catch(() => reject({message: 'Unable to fetch tags'}));
            });
        },

        fetchTranslationsForTag({}, tag_id) {
            return new Promise((resolve, reject) => {
               axios.get(`/admin/tags/${tag_id}/translations`)
                   .then(({data}) => resolve(data))
                   .catch(() => reject({message: 'Unable to get tagged articles.'}));
            });
        },

        deleteTags({dispatch}, tag_ids) {
            return new Promise((resolve, reject) => {
                axios.delete("/admin/tags", {data: {tag_ids}})
                    .then(() => {
                        dispatch('fetchAllTags').catch(notify.error);
                        resolve({message: 'The tags have been deleted.'});
                    })
                    .catch(() => reject({message: 'Unable to delete selected tags'}));
            });
        }
    }
}
