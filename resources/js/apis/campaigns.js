import { del, get, post } from "./http";

function fetchCampaigns() {
    return get("/admin/campaigns");
}

function createCampaign(formData) {
    return post("/admin/campaigns", formData);
}

function updateCampaign(campaign_id, formData) {
    return post(`/admin/campaigns/${campaign_id}`, formData);
}

function updateCampaignNarrative(campaign_id, formData) {
    return post(`/admin/campaigns/${campaign_id}/narrative`, formData);
}

function updateCampaignEvent(campaign_id, event_id) {
    return post(`/admin/campaigns/${campaign_id}/event`, { event_id });
}

function updateCampaignPromotion(campaign_id, promotion_id) {
    return post(`/admin/campaigns/${campaign_id}/promotion`, { promotion_id });
}

function assignArticleToCampaign(campaign_id, article_id) {
    return post(`/admin/campaigns/${campaign_id}/articles`, { article_id });
}

function removeArticleFromCampaign(campaign_id, article_id) {
    return del(`/admin/campaigns/${campaign_id}/articles/${article_id}`);
}

export {
    fetchCampaigns,
    createCampaign,
    updateCampaign,
    updateCampaignNarrative,
    updateCampaignEvent,
    updateCampaignPromotion,
    assignArticleToCampaign,
    removeArticleFromCampaign,
};
