import { del, get, post } from "./http";

function getPages() {
    return get("/admin/pages");
}

function createPage(formData) {
    return post("/admin/pages", formData);
}

function updatePage(page_id, formData) {
    return post(`/admin/pages/${page_id}`, formData);
}

function updatePageContents(page_id, content, lang) {
    return post(`/admin/pages/${page_id}/content`, { content, lang });
}

function deletePage(page_id) {
    return del(`/admin/pages/${page_id}`);
}

function publishPage(page_id) {
    return post("/admin/published-pages", { page_id });
}

function retractPage(page_id) {
    return del(`/admin/published-pages/${page_id}`);
}

export {
    getPages,
    createPage,
    updatePage,
    updatePageContents,
    deletePage,
    publishPage,
    retractPage,
};
