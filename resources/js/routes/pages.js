import PagesIndex from "../components/Pages/PagesIndex";
import CreatePage from "../components/Pages/CreatePage";
import PageShell from "../components/Pages/PageShell";
import ShowPageMeta from "../components/Pages/ShowPageMeta";
import EditPageMeta from "../components/Pages/EditPageMeta";
import PublishPage from "../components/Pages/PublishPage";
import ShowPageEnglishContent from "../components/Pages/ShowPageEnglishContent";
import EditPageContent from "../components/Pages/EditPageContent";
import ShowPageChineseContent from "../components/Pages/ShowPageChineseContent";

export default [
    { path: "/pages", component: PagesIndex },
    { path: "/pages/create", component: CreatePage },
    {
        path: "/pages/:page/manage",
        component: PageShell,
        children: [
            { path: "meta", component: ShowPageMeta },
            { path: "meta/edit", component: EditPageMeta },
            { path: "publish", component: PublishPage },
            { path: "content/en", component: ShowPageEnglishContent },
            { path: "content/zh", component: ShowPageChineseContent },
            { path: "content/edit/:lang", component: EditPageContent },
        ],
    },
];
