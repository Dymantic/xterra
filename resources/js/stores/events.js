import {
    addYoutubeVideoToEvent,
    attachGalleryToEvent,
    clearEventSchedule,
    createEvent,
    createEventAccommodation,
    createEventActivity,
    createEventCourse,
    createEventRace,
    createEventTravelRoute,
    deleteEventAccommodation,
    deleteEventActivity,
    deleteEventCourse,
    deleteEventYoutubeVideo,
    deleteTravelRoute,
    fetchEventActivityCategories,
    fetchEvents,
    removeGalleryFromEvent,
    saveEventFees,
    saveEventPrizes,
    saveEventSchedule,
    saveGeneralEventInfo,
    updateCourseImagePositions,
    updateEventAccommodation,
    updateEventActivity,
    updateEventCourse,
    updateEventOverview,
    updateEventRace,
    updateEventTravelRoute,
    updateEventYoutubeVideo,
} from "../apis/events";
import { notify } from "../components/Messaging/notify";

export default {
    namespaced: true,

    state: {
        all: [],
        current_page_event: null,
        activity_categories: {
            run: "run",
            swim: "swim",
            cycle: "cycle",
            lifestyle: "lifestyle",
        },
    },

    getters: {
        byId: (state) => (id) => state.all.find((ev) => ev.id === parseInt(id)),

        currentEventActivityById: (state) => (id) => {
            if (!state.current_page_event) {
                return null;
            }

            return state.current_page_event.activities.find(
                (act) => act.id === parseInt(id)
            );
        },

        currentEventSchedule: (state) =>
            state.current_page_event ? state.current_page_event.schedule : [],

        currentEventAccommodations: (state) =>
            state.current_page_event
                ? state.current_page_event.accommodation
                : [],

        accommodationById: (state) => (id) => {
            if (!state.current_page_event) {
                return null;
            }

            return state.current_page_event.accommodation.find(
                (acc) => acc.id === parseInt(id)
            );
        },

        currentEventTravelRoutes: (state) =>
            state.current_page_event
                ? state.current_page_event.travel_routes
                : [],

        travelRouteById: (state) => (id) => {
            if (!state.current_page_event) {
                return null;
            }

            return state.current_page_event.travel_routes.find(
                (route) => route.id === parseInt(id)
            );
        },

        currentEventVideos: (state) =>
            state.current_page_event ? state.current_page_event.videos : [],

        currentEventCourses: (state) =>
            state.current_page_event ? state.current_page_event.courses : [],

        currentEventGalleries: (state) =>
            state.current_page_event ? state.current_page_event.galleries : [],

        courseById: (state) => (id) => {
            if (!state.current_page_event) {
                return null;
            }

            return state.current_page_event.courses.find(
                (course) => course.id === parseInt(id)
            );
        },
    },

    mutations: {
        setEvents(state, events) {
            state.all = events;
        },

        setCurrentPage(state, event) {
            state.current_page_event = event;
        },

        setActivityCategories(state, categories) {
            state.activity_categories = categories;
        },
    },

    actions: {
        fetchAll({ commit }) {
            return fetchEvents().then((events) => commit("setEvents", events));
        },

        refreshEvents({ dispatch, state }) {
            dispatch("fetchAll")
                .catch(() =>
                    notify.error({ message: "Unable to fetch event info" })
                )
                .then(() => {
                    if (state.current_page_event) {
                        dispatch("getCurrentPage", state.current_page_event.id);
                    }
                });
        },

        fetchCategories({ commit }) {
            return fetchEventActivityCategories().then((categories) =>
                commit("setActivityCategories", categories)
            );
        },

        getCurrentPage({ getters, commit, dispatch }, id) {
            return new Promise((resolve, reject) => {
                let in_store = getters.byId(id);

                if (in_store) {
                    commit("setCurrentPage", in_store);
                    resolve(in_store);
                    return;
                }

                dispatch("fetchAll").then(() => {
                    let in_store = getters.byId(id);

                    if (in_store) {
                        commit("setCurrentPage", in_store);
                        resolve(in_store);
                        return;
                    }

                    reject({ message: "Unable to locate event" });
                });
            });
        },

        createNew({ dispatch }, formData) {
            return createEvent(formData).then(() => dispatch("fetchAll"));
        },

        updateGeneralInfo({ dispatch }, { event_id, formData }) {
            return saveGeneralEventInfo(event_id, formData).then(() =>
                dispatch("refreshEvents")
            );
        },

        addEventRace({ dispatch }, { event_id, formData }) {
            return createEventRace(event_id, formData).then(() =>
                dispatch("refreshEvents")
            );
        },

        addEventActivity({ dispatch }, { event_id, formData }) {
            return createEventActivity(event_id, formData).then(() =>
                dispatch("refreshEvents")
            );
        },

        updateActivity({ dispatch }, { activity_id, formData }) {
            return updateEventActivity(activity_id, formData).then(() =>
                dispatch("refreshEvents")
            );
        },

        updateRace({ dispatch }, { activity_id, formData }) {
            return updateEventRace(activity_id, formData).then(() =>
                dispatch("refreshEvents")
            );
        },

        deleteActivity({ dispatch }, activity_id) {
            return deleteEventActivity(activity_id).then(() =>
                dispatch("refreshEvents")
            );
        },

        savePrizes({ dispatch }, { event_id, prizes }) {
            return saveEventPrizes(event_id, prizes).then(() =>
                dispatch("refreshEvents")
            );
        },

        saveFees({ dispatch }, { event_id, fees }) {
            return saveEventFees(event_id, fees).then(() =>
                dispatch("refreshEvents")
            );
        },

        saveSchedule({ dispatch }, { event_id, schedule }) {
            return saveEventSchedule(event_id, schedule).then(() =>
                dispatch("refreshEvents")
            );
        },

        clearSchedule({ dispatch }, event_id) {
            return clearEventSchedule(event_id).then(() =>
                dispatch("refreshEvents")
            );
        },

        createAccommodation({ dispatch }, { event_id, formData }) {
            return createEventAccommodation(event_id, formData).then(() =>
                dispatch("refreshEvents")
            );
        },

        updateAccommodation({ dispatch }, { accommodation_id, formData }) {
            return updateEventAccommodation(
                accommodation_id,
                formData
            ).then(() => dispatch("refreshEvents"));
        },

        removeAccommodation({ dispatch }, accommodation_id) {
            return deleteEventAccommodation(accommodation_id).then(() =>
                dispatch("refreshEvents")
            );
        },

        createTravelRoute({ dispatch }, { event_id, formData }) {
            return createEventTravelRoute(event_id, formData).then(() =>
                dispatch("refreshEvents")
            );
        },

        updateTravelRoute({ dispatch }, { route_id, formData }) {
            return updateEventTravelRoute(route_id, formData).then(() =>
                dispatch("refreshEvents")
            );
        },

        removeTravelRoute({ dispatch }, route_id) {
            return deleteTravelRoute(route_id).then(() =>
                dispatch("refreshEvents")
            );
        },

        createCourse({ dispatch }, { event_id, formData }) {
            return createEventCourse(event_id, formData).then(() =>
                dispatch("refreshEvents")
            );
        },

        updateCourse({ dispatch }, { course_id, formData }) {
            return updateEventCourse(course_id, formData).then(() =>
                dispatch("refreshEvents")
            );
        },

        removeCourse({ dispatch }, course_id) {
            return deleteEventCourse(course_id).then(() =>
                dispatch("refreshEvents")
            );
        },

        setCourseImagePositions({ dispatch }, { course_id, image_ids }) {
            return updateCourseImagePositions(course_id, image_ids).then(() =>
                dispatch("refreshEvents")
            );
        },

        updateOverview({ dispatch }, { event_id, formData }) {
            return updateEventOverview(event_id, formData).then(() =>
                dispatch("refreshEvents")
            );
        },

        attachYoutubeVideo({ dispatch }, { event_id, formData }) {
            return addYoutubeVideoToEvent(event_id, formData).then(() =>
                dispatch("refreshEvents")
            );
        },

        updateYoutubeVideo({ dispatch }, { id, formData }) {
            return updateEventYoutubeVideo(id, formData).then(() =>
                dispatch("refreshEvents")
            );
        },

        deleteYoutubeVideo({ dispatch }, id) {
            return deleteEventYoutubeVideo(id).then(() =>
                dispatch("refreshEvents")
            );
        },

        attachGallery({ dispatch }, { event_id, gallery_id }) {
            return attachGalleryToEvent(event_id, gallery_id).then(() =>
                dispatch("refreshEvents")
            );
        },

        removeGallery({ dispatch }, { event_id, gallery_id }) {
            return removeGalleryFromEvent(event_id, gallery_id).then(() =>
                dispatch("refreshEvents")
            );
        },
    },
};
