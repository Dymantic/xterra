import { del, get, post } from "./http";

function fetchContentCards() {
    return get("/admin/content-cards");
}

function createContentCard(formData) {
    return post(`/admin/content-cards`, formData);
}

function updateContentCard(card_id, formData) {
    return post(`/admin/content-cards/${card_id}`, formData);
}

function deleteContentCard(card_id) {
    return del(`/admin/content-cards/${card_id}`);
}

function createContentCardFromArticle(article_id) {
    return post(`/admin/article-content-cards`, { article_id });
}

function createContentCardFromEvent(event_id) {
    return post("/admin/event-content-cards", { event_id });
}

function createContentCardFromPromotion(promotion_id) {
    return post(`/admin/promotion-content-cards`, { promotion_id });
}

function setContentCardsOrder(card_ids) {
    return post("/admin/content-cards-order", { card_ids });
}

export {
    fetchContentCards,
    createContentCard,
    updateContentCard,
    deleteContentCard,
    createContentCardFromArticle,
    createContentCardFromEvent,
    createContentCardFromPromotion,
    setContentCardsOrder,
};
