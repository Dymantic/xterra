import { del, get, post } from "./http";

function fetchAllGalleries() {
    return get("/admin/galleries");
}

function createNewGallery(formData) {
    return post(`/admin/galleries`, formData);
}

function updateGallery(gallery_id, formData) {
    return post(`/admin/galleries/${gallery_id}`, formData);
}

function deleteGallery(gallery_id) {
    return del(`/admin/galleries/${gallery_id}`);
}

function setGalleryImageOrder(gallery_id, formData) {
    return post(`/admin/galleries/${gallery_id}/image-order`, formData);
}

export {
    fetchAllGalleries,
    createNewGallery,
    updateGallery,
    deleteGallery,
    setGalleryImageOrder,
};
