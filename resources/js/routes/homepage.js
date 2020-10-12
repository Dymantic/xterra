import MainPage from "../components/HomePage/MainPage";
import HomePageShell from "../components/HomePage/HomePageShell";
import HomePageBannerImage from "../components/HomePage/HomePageBannerImage";
import HomePageBannerVideo from "../components/HomePage/HomePageBannerVideo";
import HomePageBannerText from "../components/HomePage/HomePageBannerText";
import HomePageCampaign from "../components/HomePage/HomePageCampaign";
import HomePageEvent from "../components/HomePage/HomePageEvent";
import HomePagePromotion from "../components/HomePage/HomePagePromotion";
import EditHomePageBannerText from "../components/HomePage/EditHomePageBannerText";
import HomePagePromoVideo from "../components/HomePage/HomePagePromoVideo";

export default [
    {
        path: "/homepage",
        component: HomePageShell,
        children: [
            { path: "/", redirect: "banner-image" },
            { path: "banner-image", component: HomePageBannerImage },
            { path: "banner-video", component: HomePageBannerVideo },
            { path: "promo-video", component: HomePagePromoVideo },
            { path: "banner-text", component: HomePageBannerText },
            { path: "banner-text/edit", component: EditHomePageBannerText },
            { path: "campaign", component: HomePageCampaign },
            { path: "event", component: HomePageEvent },
            { path: "promotion", component: HomePagePromotion },
        ],
    },
];
