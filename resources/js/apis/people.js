import { del, get, post } from "./http";

function getAmbassadors() {
    return get("/admin/ambassadors");
}

function createAmbassador(formData) {
    return post("/admin/ambassadors", formData);
}

function updateAmbassador(ambassador_id, formData) {
    return post(`/admin/ambassadors/${ambassador_id}`, formData);
}

function deleteAmbassador(ambassador_id) {
    return del(`/admin/ambassadors/${ambassador_id}`);
}

function attachAmbassadorVideo(ambassador_id, formData) {
    return post(`/admin/ambassadors/${ambassador_id}/youtube-videos`, formData);
}

function publishAmbassador(ambassador_id) {
    return post(`/admin/published-ambassadors`, { ambassador_id });
}

function retractAmbassador(ambassador_id) {
    return del(`/admin/published-ambassadors/${ambassador_id}`);
}

function getCoaches() {
    return get("/admin/coaches");
}

function createCoach(formData) {
    return post("/admin/coaches", formData);
}

function updateCoach(coach_id, formData) {
    return post(`/admin/coaches/${coach_id}`, formData);
}

function deleteCoach(coach_id) {
    return del(`/admin/coaches/${coach_id}`);
}

function attachCoachVideo(coach_id, formData) {
    return post(`/admin/coaches/${coach_id}/youtube-videos`, formData);
}

function publishCoach(coach_id) {
    return post(`/admin/published-coaches`, { coach_id });
}

function retractCoach(coach_id) {
    return del(`/admin/published-coaches/${coach_id}`);
}

export {
    getAmbassadors,
    createAmbassador,
    updateAmbassador,
    deleteAmbassador,
    attachAmbassadorVideo,
    publishAmbassador,
    retractAmbassador,
    getCoaches,
    createCoach,
    updateCoach,
    deleteCoach,
    attachCoachVideo,
    publishCoach,
    retractCoach,
};
