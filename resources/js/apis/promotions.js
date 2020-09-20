import { del, get, post } from "./http";

function fetchPromotions() {
    return get("/admin/promotions");
}

function createPromotion(formData) {
    return post(`/admin/promotions`, formData);
}

function updatePromotion(promo_id, formData) {
    return post(`/admin/promotions/${promo_id}`, formData);
}

function deletePromotion(promo_id) {
    return del(`/admin/promotions/${promo_id}`);
}

function publishPromotion(promo_id) {
    return post("/admin/published-promotions", { promotion_id: promo_id });
}

function retractPromotion(promo_id) {
    return del(`/admin/published-promotions/${promo_id}`);
}

export {
    fetchPromotions,
    createPromotion,
    updatePromotion,
    deletePromotion,
    publishPromotion,
    retractPromotion,
};
