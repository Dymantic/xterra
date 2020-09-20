import EventsIndex from "../components/Events/EventsIndex";
import EventEdit from "../components/Events/EventEdit";
import EventGeneralInfoForm from "../components/Events/EventGeneralInfoForm";
import EventShow from "../components/Events/EventShow";
import EventActivitiesIndex from "../components/Events/EventActivitiesIndex";
import CreateEventActivity from "../components/Events/CreateEventActivity";
import UpdateEventActivity from "../components/Events/UpdateEventActivity";
import PrizeList from "../components/Events/PrizeList";
import FeesList from "../components/Events/FeesList";
import ScheduleOrganizer from "../components/Events/ScheduleOrganizer";
import EventAccommodationsPage from "../components/Events/EventAccommodationsPage";
import CreateAccommodation from "../components/Events/CreateAccommodation";
import EditAccommodation from "../components/Events/EditAccommodation";
import TravelRoutesPage from "../components/Events/TravelRoutesPage";
import CreateTravelRoute from "../components/Events/CreateTravelRoute";
import EditTravelRoute from "../components/Events/EditTravelRoute";
import EventCoursesPage from "../components/Events/EventCoursesPage";
import CreateEventCourse from "../components/Events/CreateEventCourse";
import CourseGallery from "../components/Events/CourseGallery";
import EditEventCourse from "../components/Events/EditEventCourse";
import EventOverviewEditor from "../components/Events/EventOverviewEditor";
import EventVideosPage from "../components/Events/EventVideosPage";
import EventGalleries from "../components/Events/EventGalleries";
import EventImages from "../components/Events/EventImages";
export default [
    { path: "/events", component: EventsIndex },
    { path: "/events/:id", component: EventShow },
    {
        path: "/events/:id/edit",
        component: EventEdit,
        children: [
            {
                path: "general",
                component: EventGeneralInfoForm,
            },
            {
                path: "activities",
                component: EventActivitiesIndex,
            },
            {
                path: "activities/create",
                component: CreateEventActivity,
            },
            {
                path: "activities/:activity/edit",
                component: UpdateEventActivity,
            },
            {
                path: "prizes",
                component: PrizeList,
            },
            {
                path: "fees",
                component: FeesList,
            },
            {
                path: "schedule",
                component: ScheduleOrganizer,
            },
            {
                path: "accommodation",
                component: EventAccommodationsPage,
            },
            {
                path: "accommodation/create",
                component: CreateAccommodation,
            },
            {
                path: "accommodations/:accommodation/edit",
                component: EditAccommodation,
            },
            {
                path: "travel-routes",
                component: TravelRoutesPage,
            },
            {
                path: "travel-routes/create",
                component: CreateTravelRoute,
            },
            {
                path: "travel-routes/:travelRoute/edit",
                component: EditTravelRoute,
            },
            {
                path: "courses",
                component: EventCoursesPage,
            },
            {
                path: "courses/create",
                component: CreateEventCourse,
            },
            {
                path: "courses/:course/edit",
                component: EditEventCourse,
            },
            {
                path: "courses/:course/gallery",
                component: CourseGallery,
            },
            {
                path: "overview",
                component: EventOverviewEditor,
            },
            {
                path: "videos",
                component: EventVideosPage,
            },
            {
                path: "galleries",
                component: EventGalleries,
            },
            {
                path: "images",
                component: EventImages,
            },
        ],
    },
];
