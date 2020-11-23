import { del, get, post } from "./http";

function fetchCampaigns() {
    return get("/admin/campaigns");
}

function createCampaign(formData) {
    return post("/admin/campaigns", formData);
}

function deleteCampaign(campaign_id) {
    return del(`/admin/campaigns/${campaign_id}`);
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

function attachCampaignPromoVideo(campaign_id, formData) {
    return post(`/admin/campaigns/${campaign_id}/promo-video`, formData);
}

function clearCampaignPromoVideo(campaign_id) {
    return del(`/admin/campaigns/${campaign_id}/promo-video`);
}

function publishCampaign(campaign_id) {
    return post("/admin/published-campaigns", { campaign_id });
}

function retractCampaign(campaign_id) {
    return del(`/admin/published-campaigns/${campaign_id}`);
}

function attachCoachToCampaign(campaign_id, coach_id) {
    return post(`/admin/campaigns/${campaign_id}/coaches`, { coach_id });
}

function detachCoachFromCampaign(campaign_id, coach_id) {
    return del(`/admin/campaigns/${campaign_id}/coaches/${coach_id}`);
}

function attachAmbassadorToCampaign(campaign_id, ambassador_id) {
    return post(`/admin/campaigns/${campaign_id}/ambassadors`, {
        ambassador_id,
    });
}

function detachAmbassadorFromCampaign(campaign_id, ambassador_id) {
    return del(`/admin/campaigns/${campaign_id}/ambassadors/${ambassador_id}`);
}

export {
    fetchCampaigns,
    createCampaign,
    deleteCampaign,
    updateCampaign,
    updateCampaignNarrative,
    updateCampaignEvent,
    updateCampaignPromotion,
    assignArticleToCampaign,
    removeArticleFromCampaign,
    attachCampaignPromoVideo,
    clearCampaignPromoVideo,
    publishCampaign,
    retractCampaign,
    attachCoachToCampaign,
    detachCoachFromCampaign,
    attachAmbassadorToCampaign,
    detachAmbassadorFromCampaign,
};
