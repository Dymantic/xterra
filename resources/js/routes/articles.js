import ArtilcesIndex from "../components/Blog/ArticlesIndex";
import Article from "../components/Blog/Article";
import TranslationEditor from "../components/Blog/TranslationEditor";
import CategoriesIndex from "../components/Blog/CategoriesIndex";
import CategoryPage from "../components/Blog/CategoryPage";
import AddCategory from "../components/Blog/AddCategory";
import EditCategory from "../components/Blog/EditCategory";
import TagsManagerPage from "../components/Blog/TagsManagerPage";
import TagAndTranslationsPage from "../components/Blog/TagAndTranslationsPage";
import PruneTagsPage from "../components/Blog/PruneTagsPage";
import ArticlesSearch from "../components/Blog/ArticlesSearch";

export default [
    {path: '/', redirect: '/articles'},
    {path: '/articles', component: ArtilcesIndex},
    {path: '/search-articles', component: ArticlesSearch},
    {path: '/articles/:id', component: Article},
    {path: '/translations/:id/edit', component: TranslationEditor},
    {path: '/categories', component: CategoriesIndex},
    {path: '/categories/create', component: AddCategory},
    {path: '/categories/:id', component: CategoryPage},
    {path: '/categories/:id/edit', component: EditCategory},
    {path: '/tags', component: TagsManagerPage},
    {path: '/tags/prune', component: PruneTagsPage},
    {path: '/tags/:id', component: TagAndTranslationsPage},
];
