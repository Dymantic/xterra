import { get } from "./http";

function getInstagramFeed() {
    return get("/admin/instagram");
}

export { getInstagramFeed };
