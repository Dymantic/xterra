import axios from "axios";

function fetchCategories() {
    return new Promise((resolve, reject) => {
        axios.get("/admin/categories")
             .then(({data}) => resolve(data))
             .catch(() => reject({message: 'Unable to fetch categories'}));
    });
}

function addCategory(formData) {
    return new Promise((resolve, reject) => {
        axios.post("/admin/categories", formData)
             .then(() => resolve({message: 'Category has been successfully added.'}))
             .catch(({response}) => reject(response));
    });
}

function updateCategory(id, formData) {
    return new Promise((resolve, reject) => {
        axios.post(`/admin/categories/${id}`, formData)
             .then(() => resolve({message: 'Category has been successfully updated.'}))
             .catch(({response}) => reject(response));
    });
}

function removeCategory(id) {
    return new Promise((resolve, reject) => {
        axios.delete(`/admin/categories/${id}`)
             .then(() => resolve({message: 'Category has been removed.'}))
             .catch(() => reject({message: 'Unable to delete category.'}));
    });
}

export {fetchCategories, addCategory, updateCategory, removeCategory};
