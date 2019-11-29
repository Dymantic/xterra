import {notify} from "../components/Messaging/notify";
import {sortByStringProp} from "../sorting";
import {
    addArticleTranslation,
    createArticle, deleteArticle,
    fetchArticles,
    searchArticles,
    setArticleCategories
} from "../apis/articles";
import {addCategory, fetchCategories, removeCategory, updateCategory} from "../apis/categories";
import {getTranslationById, publishTranslation, retractTranslation, saveTranslation} from "../apis/translations";
import {deleteTags, fetchTags, translationsForTag} from "../apis/tags";


export default {

    namespaced: true,

    state: {
        articles: [],
        categories: [],
        tags: [],
    },

    getters: {
        article: state => id => {
            return state.articles.find(art => parseInt(art.id) === parseInt(id));
        },

        categoryById: state => id => state.categories.find(cat => parseInt(cat.id) === parseInt(id)),

        articlesByCategoryId: state => id => {
            return state.articles
                        .filter(art => art.categories.map(cat => cat.id).includes(parseInt(id)));
        },

        tagsByName: state => {
            return state.tags.sort(sortByStringProp('tag_name'));
        },

        tagsByCount: state => state.tags.sort((a,b) => b.translations_count - a.translations_count),

        tagById: state => id => state.tags.find(tag => parseInt(tag.id) === parseInt(id)),
    },

    mutations: {
        setArticles(state, articles) {
            state.articles = articles;
        },

        setCategories(state, categories) {
            state.categories = categories;
        },

        setTags(state, tags) {
            state.tags = tags;
        }

    },

    actions: {

        fetchAll({commit}, page = 1) {

            return fetchArticles(page)
                .then(articles => commit('setArticles', articles));
        },

        fetchCategories({commit}) {
            return fetchCategories()
                .then(categories => commit('setCategories', categories))
        },

        setCategories({state, dispatch}, {article_id, category_ids}) {
            return setArticleCategories(article_id, category_ids);
        },

        createArticle({dispatch}, formData) {
            return createArticle(formData)
                .then(article => {
                    dispatch('fetchAll').catch(() => notify.error);
                    return article;
                });
        },

        searchArticles({}, title) {
            return searchArticles(title);
        },

        deleteArticle({dispatch}, id) {
            return deleteArticle(id)
                .then(() => dispatch('fetchAll').catch(notify.error));
        },

        getTranslationById({}, id) {
            return getTranslationById(id);
        },

        saveTranslation({}, {id, formData}) {
            return saveTranslation(id, formData);
        },

        addTranslation({dispatch}, {article_id, lang, title}) {
            return addArticleTranslation(article_id, lang, title)
                .then(translation => {
                    dispatch('fetchAll').catch(() => notify.error);
                    return translation;
                });
        },

        publishTranslation({dispatch}, formData) {
            return publishTranslation(formData)
                .then(translation => {
                    dispatch('fetchAll').catch(notify.error);
                    return translation;
                });
        },

        retractTranslation({dispatch}, id) {
            return retractTranslation(id)
                .then(translation => {
                    dispatch('fetchAll').catch(notify.error);
                    return translation;
                })
        },

        addCategory({dispatch}, formData) {
            return addCategory(formData)
                .then(message => {
                    dispatch('fetchCategories').catch(notify.error);
                    return message;
                });
        },

        updateCategory({dispatch}, {id, formData}) {
            return updateCategory(id, formData)
                .then(message => {
                    dispatch('fetchCategories').catch(notify.error);
                    return message;
                });
        },

        removeCategory({dispatch}, id) {
            return removeCategory(id)
                .then(message => {
                    dispatch('fetchCategories').catch(notify.error);
                    return message;
                });
        },

        fetchAllTags({commit}) {
            return fetchTags()
                .then(tags => commit('setTags', tags));
        },

        fetchTranslationsForTag({}, tag_id) {
            return translationsForTag(tag_id);
        },

        deleteTags({dispatch}, tag_ids) {
            return deleteTags(tag_ids)
                .then(message => {
                    dispatch('fetchAllTags').catch(notify.error);
                    return message;
                });
        },
    }
}
