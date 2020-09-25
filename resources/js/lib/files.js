import { FileUploader } from "./FileUploader";

function getImageFileSrc(file) {
    return new Promise((resolve, reject) => {
        const fileReader = new FileReader();
        fileReader.onload = (ev) => resolve(ev.target.result);
        fileReader.onerror = (err) => reject(err);

        fileReader.readAsDataURL(file);
    });
}

function uploadFile(file) {
    return new FileUploader(file);
}

function readableFilename(original_filename, name, suffix) {
    const ext = original_filename.split(".").pop();
    return `${name.replace(/ /g, "_")}_${suffix}.${ext}`;
}

export { getImageFileSrc, uploadFile, readableFilename };
