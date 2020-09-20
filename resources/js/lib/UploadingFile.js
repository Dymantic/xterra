export class UploadingFile {
    constructor(file) {
        this.progress = 0;
        this.name = file.name;
        this.complete = false;
    }

    setProgress(progress) {
        this.progress = progress;
    }

    completed() {
        this.complete = true;
    }
}
