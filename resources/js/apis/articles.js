import axios from "axios";
import {notify} from "../components/Messaging/notify";

function fetchArticles(page = 1) {
    return new Promise((resolve, reject) => {
        axios.get(`/admin/articles?page=${page}`)
             .then(({data}) => {
                 resolve(data);
             })
             .catch(() => reject({message: `Unable to fetch page ${page} of articles`}));
    });
}

function setArticleCategories(article_id, category_ids) {
    return new Promise((resolve, reject) => {
        axios.post(`/admin/articles/${article_id}/categories`, {category_ids})
             .then(resolve)
             .catch(({response}) => reject(response));
    });
}

function createArticle(formData) {
    return new Promise((resolve, reject) => {
        axios.post("/admin/articles", formData)
             .then(({data}) => resolve(data))
             .catch(({response}) => reject(response));
    });
}

function addArticleTranslation(article_id, lang, title) {
    return new Promise((resolve, reject) => {
        axios.post(`/admin/articles/${article_id}/translations`, {lang, title})
             .then(({data}) => resolve(data))
             .catch(({response}) => reject(response));
    });
}

function searchArticles(title) {
    return new Promise((resolve, reject) => {
        axios.get(`/admin/search/articles?query=${title}`)
             .then(({data}) => resolve(data))
             .catch(() => reject({message: 'Error whilst search articles'}));
    });
}

function deleteArticle(id) {
    return new Promise((resolve, reject) => {
        axios.delete(`/admin/articles/${id}`)
             .then(resolve)
             .catch(() => reject({message: 'Unable to delete article'}));
    });
}

export {fetchArticles, setArticleCategories, createArticle, addArticleTranslation, searchArticles, deleteArticle};
