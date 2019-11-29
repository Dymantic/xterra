import axios from "axios";

function getTranslationById(id) {
    return new Promise((resolve, reject) => {
        axios.get(`/admin/translations/${id}`)
             .then(({data}) => resolve(data))
             .catch(({response}) => reject(response));
    });
}

function saveTranslation(id, formData) {
    return new Promise((resolve, reject) => {
        axios.post(`/admin/translations/${id}`, formData)
             .then(resolve)
             .catch(({response}) => reject(response));
    });
}

function publishTranslation(formData) {
    return new Promise((resolve, reject) => {
        axios.post("/admin/published-translations", formData)
             .then(({data}) => resolve(data))
             .catch(({response}) => reject(response));
    });
}

function retractTranslation(id) {
    return new Promise((resolve, reject) => {
        axios.delete(`/admin/published-translations/${id}`)
             .then(({data}) => resolve(data))
             .catch(({response}) => reject(response));
    });
}


export {getTranslationById, saveTranslation, publishTranslation, retractTranslation};
