import CardIndex from "../components/ContentCards/CardIndex";
import CreateCard from "../components/ContentCards/CreateCard";
import EditCard from "../components/ContentCards/EditCard";
import ShowCard from "../components/ContentCards/ShowCard";
import ContentCardsOrder from "../components/ContentCards/ContentCardsOrder";

export default [
    { path: "/content-cards", component: CardIndex },
    { path: "/content-cards/create", component: CreateCard },
    { path: "/content-cards/order", component: ContentCardsOrder },
    { path: "/content-cards/:card/show", component: ShowCard },
    { path: "/content-cards/:card/edit", component: EditCard },
];
