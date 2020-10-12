import CampaignsIndex from "../components/Campaigns/CampaignsIndex";
import CreateCampaign from "../components/Campaigns/CreateCampaign";
import ShowCampaign from "../components/Campaigns/ShowCampaign";
import EditCampaign from "../components/Campaigns/EditCampaign";
import CampaignEditor from "../components/Campaigns/CampaignEditor";
import CampaignShell from "../components/Campaigns/CampaignShell";
import CampaignImages from "../components/Campaigns/CampaignImages";
import CampaignVideos from "../components/Campaigns/CampaignVideos";
import CampaignContent from "../components/Campaigns/CampaignContent";
import CampaignEvent from "../components/Campaigns/CampaignEvent";
import CampaignPromotion from "../components/Campaigns/CampaignPromotion";
import CampaignArticles from "../components/Campaigns/CampaignArticles";
import CampaignGeneralInfo from "../components/Campaigns/CampaignGeneralInfo";

export default [
    { path: "/campaigns", component: CampaignsIndex },
    { path: "/campaigns/create", component: CreateCampaign },
    {
        path: "/campaigns/:campaign/show",
        component: CampaignShell,
        children: [
            { path: "/", redirect: "general" },
            { path: "general", component: CampaignGeneralInfo },
            { path: "edit", component: EditCampaign },
            { path: "images", component: CampaignImages },
            { path: "videos", component: CampaignVideos },
            { path: "content", component: CampaignContent },
            { path: "event", component: CampaignEvent },
            { path: "promotion", component: CampaignPromotion },
            { path: "articles", component: CampaignArticles },
            { path: "content/edit/:lang", component: CampaignEditor },
        ],
    },
];
