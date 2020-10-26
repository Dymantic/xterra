import EventsIndex from "../components/Events/EventsIndex";
import EventEdit from "../components/Events/EventEdit";
import EventGeneralInfoForm from "../components/Events/EventGeneralInfoForm";
import EventShow from "../components/Events/EventShow";
import EventActivitiesIndex from "../components/Events/EventActivitiesIndex";
import CreateEventActivity from "../components/Events/CreateEventActivity";
import UpdateEventActivity from "../components/Events/UpdateEventActivity";
import ScheduleOrganizer from "../components/Events/ScheduleOrganizer";
import EventAccommodationsPage from "../components/Events/EventAccommodationsPage";
import CreateAccommodation from "../components/Events/CreateAccommodation";
import EditAccommodation from "../components/Events/EditAccommodation";
import TravelRoutesPage from "../components/Events/TravelRoutesPage";
import CreateTravelRoute from "../components/Events/CreateTravelRoute";
import EditTravelRoute from "../components/Events/EditTravelRoute";
import CreateEventCourse from "../components/Events/CreateEventCourse";
import CourseGallery from "../components/Events/CourseGallery";
import EditEventCourse from "../components/Events/EditEventCourse";
import EventOverviewEditor from "../components/Events/EventOverviewEditor";
import EventVideosPage from "../components/Events/EventVideosPage";
import EventGalleries from "../components/Events/EventGalleries";
import EventImages from "../components/Events/EventImages";
import EventSchedulePlanner from "../components/Events/EventSchedulePlanner";
import RaceSchedulePlanner from "../components/Events/RaceSchedulePlanner";
import RaceFeesList from "../components/Events/RaceFeesList";
import EventFeesList from "../components/Events/EventFeesList";
import RaceCoursesPage from "../components/Events/RaceCoursesPage";
import RaceEditPage from "../components/Events/RaceEditPage";
import RaceScheduleNotes from "../components/Events/RaceScheduleNotes";
import RacePrizeNotes from "../components/Events/RacePrizeNotes";
import RaceFeesNotes from "../components/Events/RaceFeesNotes";
import RaceFiles from "../components/Events/RaceFiles";
import RaceRulesEditor from "../components/Events/RaceRulesEditor";
import RaceInfoEditor from "../components/Events/RaceInfoEditor";
import ShowRaceRules from "../components/Events/ShowRaceRules";
import ShowRaceInfo from "../components/Events/ShowRaceInfo";
import ShowRaceDescription from "../components/Events/ShowRaceDescription";
import RaceDescriptionEditor from "../components/Events/RaceDescriptionEditor";
import RaceTitleImages from "../components/Events/RaceTitleImages";
import RacePromoVideo from "../components/Events/RacePromoVideo";
import ShowRacePrizes from "../components/Events/ShowRacePrizes";
import PrizeTableEditor from "../components/Events/PrizeTableEditor";
import EventSponsorsIndex from "../components/Events/EventSponsorsIndex";
import SponsorCreate from "../components/Events/SponsorCreate";
import SponsorEdit from "../components/Events/SponsorEdit";
import SponsorsOrder from "../components/Events/SponsorsOrder";
import EventPublishPage from "../components/Events/EventPublishPage";
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
                path: "fees",
                component: EventFeesList,
            },
            {
                path: "schedule",
                component: EventSchedulePlanner,
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
                path: "sponsors",
                component: EventSponsorsIndex,
            },
            {
                path: "sponsors/create",
                component: SponsorCreate,
            },
            {
                path: "sponsors/order",
                component: SponsorsOrder,
            },
            {
                path: "sponsors/:sponsor/edit",
                component: SponsorEdit,
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
            {
                path: "publish",
                component: EventPublishPage,
            },
        ],
    },
    {
        path: "/events/:event/races/:race/edit",
        component: RaceEditPage,
        children: [
            {
                path: "general",
                component: UpdateEventActivity,
            },
            {
                path: "images",
                component: RaceTitleImages,
            },
            {
                path: "fees",
                component: RaceFeesList,
            },
            {
                path: "fees-notes",
                component: RaceFeesNotes,
            },
            {
                path: "courses",
                component: RaceCoursesPage,
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
                path: "prizes",
                component: ShowRacePrizes,
            },
            {
                path: "prizes/:lang/edit",
                component: PrizeTableEditor,
            },
            {
                path: "prize-notes",
                component: RacePrizeNotes,
            },
            {
                path: "schedule",
                component: RaceSchedulePlanner,
            },
            {
                path: "schedule-notes",
                component: RaceScheduleNotes,
            },
            {
                path: "files",
                component: RaceFiles,
            },
            {
                path: "rules/show",
                component: ShowRaceRules,
            },
            {
                path: "info/show",
                component: ShowRaceInfo,
            },
            {
                path: "description/show",
                component: ShowRaceDescription,
            },
            {
                path: "rules/:lang/edit",
                component: RaceRulesEditor,
            },
            {
                path: "info/:lang/edit",
                component: RaceInfoEditor,
            },
            {
                path: "description/:lang/edit",
                component: RaceDescriptionEditor,
            },
            {
                path: "video",
                component: RacePromoVideo,
            },
        ],
    },
];
