import { del, get, post } from "./http";

function fetchHomePageInfo() {
    return get("/admin/home-page");
}

function updateHomePageBannerText(formData) {
    return post("/admin/home-page/banner-text", formData);
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

function attachHomePagePromoVideo(formData) {
    return post("/admin/home-page/promo-video", formData);
}

function clearHomePagePromoVideo() {
    return del("/admin/home-page/promo-video");
}

export {
    fetchHomePageInfo,
    attachHomePageCampaign,
    attachHomePageEvent,
    attachHomePagePromotion,
    updateHomePageBannerText,
    attachHomePagePromoVideo,
    clearHomePagePromoVideo,
};
