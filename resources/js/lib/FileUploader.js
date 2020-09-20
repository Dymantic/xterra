import { upload } from "../apis/http";

export class FileUploader {
    constructor(file) {
        this.file = file;
    }

    to(url, name, onUpdate) {
        return upload({
            file: this.file,
            name: name || "image",
            onUpdate: onUpdate,
            url: url,
        });
    }
}
