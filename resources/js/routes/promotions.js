import PromotionsPage from "../components/Promotions/PromotionsPage";
import CreatePromotion from "../components/Promotions/CreatePromotion";
import ShowPromotion from "../components/Promotions/ShowPromotion";
import EditPromotion from "../components/Promotions/EditPromotion";

export default [
    { path: "/promotions", component: PromotionsPage },
    { path: "/promotions/create", component: CreatePromotion },
    { path: "/promotions/:promotion/show", component: ShowPromotion },
    { path: "/promotions/:promotion/edit", component: EditPromotion },
];
