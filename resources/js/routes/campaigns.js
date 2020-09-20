import CampaignsIndex from "../components/Campaigns/CampaignsIndex";
import CreateCampaign from "../components/Campaigns/CreateCampaign";
import ShowCampaign from "../components/Campaigns/ShowCampaign";
import EditCampaign from "../components/Campaigns/EditCampaign";
import CampaignEditor from "../components/Campaigns/CampaignEditor";

export default [
    { path: "/campaigns", component: CampaignsIndex },
    { path: "/campaigns/create", component: CreateCampaign },
    { path: "/campaigns/:campaign/show", component: ShowCampaign },
    { path: "/campaigns/:campaign/edit", component: EditCampaign },
    {
        path: "/campaigns/:campaign/edit-content/:lang",
        component: CampaignEditor,
    },
];
