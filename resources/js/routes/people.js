import CreateAmbassador from "../components/People/CreateAmbassador";
import AmbassadorsIndex from "../components/People/AmbassadorsIndex";
import AmbassadorShow from "../components/People/AmbassadorShow";
import AmbassadorEdit from "../components/People/AmbassadorEdit";
import CoachesIndex from "../components/People/CoachesIndex";
import CoachCreate from "../components/People/CoachCreate";
import CoachShow from "../components/People/CoachShow";
import CoachEdit from "../components/People/CoachEdit";

export default [
    { path: "/ambassadors", component: AmbassadorsIndex },
    { path: "/ambassadors/create", component: CreateAmbassador },
    { path: "/ambassadors/:ambassador/show", component: AmbassadorShow },
    { path: "/ambassadors/:ambassador/edit", component: AmbassadorEdit },
    { path: "/coaches", component: CoachesIndex },
    { path: "/coaches/create", component: CoachCreate },
    { path: "/coaches/:coach/show", component: CoachShow },
    { path: "/coaches/:coach/edit", component: CoachEdit },
];
