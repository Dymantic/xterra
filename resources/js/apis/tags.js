import axios from "axios";
import {notify} from "../components/Messaging/notify";

function fetchTags() {
    return new Promise((resolve, reject) => {
        axios.get("/admin/tags")
             .then(({data}) => resolve(data))
             .catch(() => reject({message: 'Unable to fetch tags'}));
    });
}

function translationsForTag(tag_id) {
    return new Promise((resolve, reject) => {
        axios.get(`/admin/tags/${tag_id}/translations`)
             .then(({data}) => resolve(data))
             .catch(() => reject({message: 'Unable to get tagged articles.'}));
    });
}

function deleteTags(tag_ids) {
    return new Promise((resolve, reject) => {
        axios.delete("/admin/tags", {data: {tag_ids}})
             .then(() => resolve({message: 'The tags have been deleted.'}))
             .catch(() => reject({message: 'Unable to delete selected tags'}));
    });
}

export {fetchTags, translationsForTag, deleteTags};
