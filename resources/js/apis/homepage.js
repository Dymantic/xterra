import { get, post } from "./http";

function fetchHomePageInfo() {
    return get("/admin/home-page");
}

function attachHomePagePromotion(promotion_id) {
    return post("/admin/home-page/featured-promotion", { promotion_id });
}

function attachHomePageEvent(event_id) {
    return post("/admin/home-page/featured-event", { event_id });
}

function attachHomePageCampaign(campaign_id) {
    return post("/admin/home-page/featured-campaign", { campaign_id });
}

export {
    fetchHomePageInfo,
    attachHomePageCampaign,
    attachHomePageEvent,
    attachHomePagePromotion,
};
