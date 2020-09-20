import GalleryPage from "../components/Galleries/GalleryPage";
import CreateGallery from "../components/Galleries/CreateGallery";
import ShowGallery from "../components/Galleries/ShowGallery";
import EditGallery from "../components/Galleries/EditGallery";

export default [
    { path: "/galleries", component: GalleryPage },
    { path: "/galleries/create", component: CreateGallery },
    { path: "/galleries/:gallery/show", component: ShowGallery },
    { path: "/galleries/:gallery/edit", component: EditGallery },
];
