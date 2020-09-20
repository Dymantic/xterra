import { FileUploader } from "../lib/FileUploader";

function makeEl(tag, { classes, id, atts }) {
    const el = document.createElement(tag);
    classes.split(" ").forEach((cl) => el.classList.add(cl));
    if (id) {
        el.id = id;
    }

    if (atts) {
        Object.keys(atts).forEach((key) => el.setAttribute(key, atts[key]));
    }
    return el;
}

function getFilePreview(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = (ev) => resolve(ev.target.result);
        reader.onerror = (err) => reject(err);
        reader.readAsDataURL(file);
    });
}

function validateFile(file, maxSize = 15) {
    console.log({ file });
    const isImg = (f) => f.type.indexOf("image") === 0;
    const tooBig = (f) => f.size > maxSize * 1000 * 1024;

    return isImg(file) && !tooBig(file);
}

function uploadFile(url, file, onProgress, upload_name = "image") {
    const uploader = new FileUploader(file);

    return uploader
        .to(url, upload_name, onProgress)
        .then((data) => data.file.url);
}

function parseJson(json_string) {
    return new Promise((resolve, reject) => {
        try {
            const parsed = JSON.parse(json_string);
            resolve(parsed);
        } catch (err) {
            reject();
        }
    });
}

export { makeEl, getFilePreview, validateFile, uploadFile };
