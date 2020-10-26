import { del, get, post } from "./http";

function fetchEvents() {
    return get("/admin/events");
}

function fetchEventActivityCategories() {
    return get("/admin/events/activity-categories");
}

function createEvent(formData) {
    return post("/admin/events/", formData);
}

function deleteEvent(event_id) {
    return del(`/admin/events/${event_id}`);
}

function saveGeneralEventInfo(event_id, formData) {
    return post(`/admin/events/${event_id}/general-info`, formData);
}

function createEventRace(event_id, formData) {
    return post(`/admin/events/${event_id}/races`, formData);
}

function createEventActivity(event_id, formData) {
    return post(`/admin/events/${event_id}/activities`, formData);
}

function updateEventActivity(activity_id, formData) {
    return post(`/admin/activities/${activity_id}`, formData);
}

function updateEventRace(activity_id, formData) {
    return post(`/admin/races/${activity_id}`, formData);
}

function deleteEventActivity(activity_id) {
    return del(`/admin/activities/${activity_id}`);
}

function saveEventRacePrizes(race_id, prizes, lang) {
    return post(`/admin/races/${race_id}/prizes`, { prizes, lang });
}

function saveEventFees(event_id, fees) {
    return post(`/admin/events/${event_id}/fees`, { fees });
}

function saveEventSchedule(event_id, schedule) {
    return post(`/admin/events/${event_id}/schedule`, { schedule });
}

function clearEventSchedule(event_id) {
    return del(`/admin/events/${event_id}/schedule`);
}

function createEventAccommodation(event_id, formData) {
    return post(`/admin/events/${event_id}/accommodation`, formData);
}

function updateEventAccommodation(accommodation_id, formData) {
    return post(`/admin/accommodations/${accommodation_id}`, formData);
}

function deleteEventAccommodation(accommodation_id) {
    return del(`/admin/accommodations/${accommodation_id}`);
}

function createEventTravelRoute(event_id, formData) {
    return post(`/admin/events/${event_id}/travel-routes`, formData);
}

function updateEventTravelRoute(route_id, formData) {
    return post(`/admin/travel-routes/${route_id}`, formData);
}

function deleteTravelRoute(route_id) {
    return del(`/admin/travel-routes/${route_id}`);
}

function createEventRaceCourse(race_id, formData) {
    return post(`/admin/races/${race_id}/courses`, formData);
}

function updateEventRaceCourse(course_id, formData) {
    return post(`/admin/courses/${course_id}`, formData);
}

function deleteEventRaceCourse(course_id) {
    return del(`/admin/courses/${course_id}`);
}

function updateCourseImagePositions(course_id, image_ids) {
    return post(`/admin/courses/${course_id}/images-order`, { image_ids });
}

function updateEventOverview(event_id, formData) {
    return post(`/admin/events/${event_id}/overview`, formData);
}

function addYoutubeVideoToEvent(event_id, formData) {
    return post(`/admin/events/${event_id}/youtube-videos`, formData);
}

function updateEventYoutubeVideo(id, formData) {
    return post(`/admin/embeddable-videos/${id}`, formData);
}

function deleteEventYoutubeVideo(id) {
    return del(`/admin/embeddable-videos/${id}`);
}

function attachGalleryToEvent(event_id, gallery_id) {
    return post(`/admin/events/${event_id}/galleries`, { gallery_id });
}

function removeGalleryFromEvent(event_id, gallery_id) {
    return del(`/admin/events/${event_id}/galleries/${gallery_id}`);
}

function saveEventRaceSchedule(race_id, schedule) {
    return post(`/admin/races/${race_id}/schedule`, { schedule });
}

function saveEventRaceFees(race_id, fees) {
    return post(`/admin/races/${race_id}/fees`, { fees });
}

function saveRaceScheduleNotes(race_id, notes) {
    return post(`/admin/races/${race_id}/schedule-notes`, { notes });
}

function saveRacePrizeNotes(race_id, notes) {
    return post(`/admin/races/${race_id}/prize-notes`, { notes });
}

function saveRaceFeesNotes(race_id, notes) {
    return post(`/admin/races/${race_id}/fees-notes`, { notes });
}

function saveEventRaceDescription(race_id, description, lang) {
    return post(`/admin/races/${race_id}/description`, { description, lang });
}

function saveEventRaceRules(race_id, rules, lang) {
    return post(`/admin/races/${race_id}/race-rules`, { rules, lang });
}

function saveEventRaceInfo(race_id, info, lang) {
    return post(`/admin/races/${race_id}/race-info`, { info, lang });
}

function saveEventRacePromoVideo(race_id, formData) {
    return post(`/admin/races/${race_id}/promo-video`, formData);
}

function attachEventPromoVideo(event_id, formData) {
    return post(`/admin/events/${event_id}/promo-video`, formData);
}

function clearEventPromoVideo(event_id) {
    return del(`/admin/events/${event_id}/promo-video`);
}

function createEventSponsor(event_id, formData) {
    return post(`/admin/events/${event_id}/sponsors`, formData);
}

function updateEventSponsor(sponsor_id, formData) {
    return post(`/admin/event-sponsors/${sponsor_id}`, formData);
}

function deleteEventSponsor(sponsor_id) {
    return del(`/admin/event-sponsors/${sponsor_id}`);
}

function setEventSponsorsOrder(sponsor_ids) {
    return post("/admin/event-sponsors-order", { sponsor_ids });
}

function publishEvent(event_id) {
    return post("/admin/published-events", { event_id });
}

function retractEvent(event_id) {
    return del(`/admin/published-events/${event_id}`);
}

export {
    fetchEvents,
    createEvent,
    saveGeneralEventInfo,
    createEventRace,
    createEventActivity,
    fetchEventActivityCategories,
    updateEventActivity,
    updateEventRace,
    deleteEventActivity,
    saveEventRacePrizes,
    saveEventFees,
    saveEventSchedule,
    clearEventSchedule,
    createEventAccommodation,
    updateEventAccommodation,
    deleteEventAccommodation,
    createEventTravelRoute,
    updateEventTravelRoute,
    deleteTravelRoute,
    createEventRaceCourse,
    updateEventRaceCourse,
    deleteEventRaceCourse,
    updateCourseImagePositions,
    updateEventOverview,
    addYoutubeVideoToEvent,
    updateEventYoutubeVideo,
    deleteEventYoutubeVideo,
    attachGalleryToEvent,
    removeGalleryFromEvent,
    saveEventRaceSchedule,
    saveEventRaceFees,
    saveRaceScheduleNotes,
    saveRacePrizeNotes,
    saveRaceFeesNotes,
    saveEventRaceDescription,
    saveEventRaceRules,
    saveEventRaceInfo,
    saveEventRacePromoVideo,
    deleteEvent,
    attachEventPromoVideo,
    clearEventPromoVideo,
    createEventSponsor,
    updateEventSponsor,
    deleteEventSponsor,
    setEventSponsorsOrder,
    publishEvent,
    retractEvent,
};
