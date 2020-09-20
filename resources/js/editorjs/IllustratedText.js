import { makeEl, getFilePreview, validateFile, uploadFile } from "./helpers";

export default class IllustratedText {
    static get toolbox() {
        return {
            title: "Media Text",
            icon: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37.95 37.95" fill="currentColor" height="32px">
            <path d="M19.54 12H2.43a1.53 1.53 0 00-1.55 1.5v11A1.53 1.53 0 002.43 26h17.11a1.53 1.53 0 001.55-1.52V13.5a1.53 1.53 0 00-1.55-1.5zm-.07 11.38l-.2.07c-1-1.45-2.81-3.58-3.76-4.68a.88.88 0 00-1.28-.05L10.83 22a.87.87 0 01-1.21 0l-2.06-1.86a.89.89 0 00-1.19 0c-1 .86-2.8 2.58-3.79 3.69a.76.76 0 01-.16-.46v-9.1a.76.76 0 01.78-.76h15.49a.78.78 0 01.78.78z" fill-rule="evenodd"/>
            <path d="M12.54 19A1.56 1.56 0 1111 17.46 1.54 1.54 0 0112.54 19z" fill-rule="evenodd"/>
            <path d="M36.56 13.88H22.92a.51.51 0 010-1h13.64a.51.51 0 010 1zM36.56 16.17H22.92a.52.52 0 010-1h13.64a.52.52 0 010 1zM36.56 18.46H22.92a.52.52 0 010-1h13.64a.52.52 0 010 1zM36.56 20.75H22.92a.52.52 0 010-1h13.64a.52.52 0 010 1zM28.75 23h-5.83a.52.52 0 010-1h5.83a.52.52 0 010 1z"/>
</svg>

`,
        };
    }

    constructor({ data = {}, api, config }) {
        this.api = api;
        this.image_upload_path = config.image_upload_path || "";
        this.imageSide = data.image_side || "right";
        this.root = null;
        this.image = null;
        this.textBlock = null;
        this.imageBlock = null;
        this.header = null;
        this.progressBox = null;
        this.progressBar = null;
        this.initial_text = data.text || "";
        this.initial_header = data.header || "";
        this.initial_image = data.image_src || `/images/default_image.svg`;
        this.last_confirmed_src = data.image_src || null;
        this.settings = [
            {
                name: "swapSides",
                icon: `<svg width="17" height="10" viewBox="0 0 17 10" xmlns="http://www.w3.org/2000/svg"><path d="M13.568 5.925H4.056l1.703 1.703a1.125 1.125 0 0 1-1.59 1.591L.962 6.014A1.069 1.069 0 0 1 .588 4.26L4.38.469a1.069 1.069 0 0 1 1.512 1.511L4.084 3.787h9.606l-1.85-1.85a1.069 1.069 0 1 1 1.512-1.51l3.792 3.791a1.069 1.069 0 0 1-.475 1.788L13.514 9.16a1.125 1.125 0 0 1-1.59-1.591l1.644-1.644z"/></svg>`,
            },
        ];
    }

    render() {
        const root = makeEl("div", {
            classes: "flex flex-col md:flex-row justify-between my-6",
        });
        const textBlock = makeEl("div", {
            classes: "w-1/2",
        });
        this.imageSide === "right"
            ? textBlock.classList.add("order-1")
            : textBlock.classList.add("order-2");
        const headerInput = makeEl("input", {
            classes: "p-2 w-full border border-gray-200 block mb-1",
            id: "it-header-input",
            atts: {
                placeholder: "The heading",
            },
        });
        headerInput.value = this.initial_header;
        const input = makeEl("div", {
            classes: "p-2 border border-gray-200 min-h-full",
            id: "it-text-input",
            atts: {
                contenteditable: true,
            },
        });
        input.innerHTML = this.initial_text;
        textBlock.appendChild(headerInput);
        textBlock.appendChild(input);

        const imageBlock = makeEl("div", {
            classes: "w-1/2",
        });
        this.imageSide === "right"
            ? imageBlock.classList.add("order-2")
            : imageBlock.classList.add("order-1");
        const img_wrapper = makeEl("div", {
            classes: "h-48 w-64 mx-auto",
        });
        const img = makeEl("img", {
            classes: "h-full w-full object-cover bg-gray-300 block",
        });
        img.src = this.initial_image;
        img_wrapper.appendChild(img);

        const file_input = makeEl("input", {
            classes: "hidden",
            id: "it-file-input",
            atts: {
                type: "file",
            },
        });
        file_input.addEventListener("input", (ev) => this._handleFile(ev));
        imageBlock.addEventListener("click", () => file_input.click());

        const progressBarOuter = makeEl("div", {
            classes: "h-2 rounded w-4/5 mx-auto bg-gray-200 mt-2 hidden",
        });
        const progressBarInner = makeEl("div", {
            classes: "h-2 rounded w-full bg-red-500 mx-auto",
            atts: {
                style: "transform-origin: top left; transform: scale(0,1)",
            },
        });
        progressBarOuter.appendChild(progressBarInner);

        imageBlock.appendChild(img_wrapper);
        imageBlock.appendChild(file_input);
        imageBlock.appendChild(progressBarOuter);

        root.appendChild(textBlock);
        root.appendChild(imageBlock);

        this.root = root;
        this.image = img;
        this.progressBox = progressBarOuter;
        this.progressBar = progressBarInner;
        this.textBlock = textBlock;
        this.imageBlock = imageBlock;

        return root;
    }

    renderSettings() {
        const wrapper = document.createElement("div");

        this.settings.forEach((tune) => {
            let button = document.createElement("div");

            button.classList.add(this.api.styles.settingsButton);
            button.innerHTML = tune.icon;

            button.addEventListener("click", () =>
                this._toggleSetting(tune.name)
            );

            wrapper.appendChild(button);
        });

        return wrapper;
    }

    save(blockContent) {
        const header = blockContent.querySelector("#it-header-input");
        const text = blockContent.querySelector("#it-text-input");

        return {
            text: text.innerHTML,
            header: header.value,
            image_src: this.last_confirmed_src,
            image_side: this.imageSide,
        };
    }

    _toggleSetting(name) {
        if (name === "swapSides") {
            this._toggleImageSide();
        }
    }

    _toggleImageSide() {
        if (this.imageSide === "left") {
            this.textBlock.classList.add("order-1");
            this.textBlock.classList.remove("order-2");

            this.imageBlock.classList.add("order-2");
            this.imageBlock.classList.remove("order-1");

            return (this.imageSide = "right");
        }

        this.textBlock.classList.add("order-2");
        this.textBlock.classList.remove("order-1");

        this.imageBlock.classList.add("order-1");
        this.imageBlock.classList.remove("order-2");

        return (this.imageSide = "left");
    }

    _handleFile({ target }) {
        if (target.files.length === 0) {
            return;
        }
        const file = target.files[0];

        if (!validateFile(file)) {
            console.log("invalid");
            return;
        }

        getFilePreview(file)
            .then((src) => (this.image.src = src))
            .catch(() => console.log("bad preview"));

        const setProgress = (percent) => this._setProgress(percent);

        this._showProgress();

        uploadFile(this.image_upload_path, file, setProgress)
            .then((src) => {
                this.image.src = src;
                this.last_confirmed_src = src;
            })
            .catch(() => console.log("boo"))
            .then(() => {
                this._hideProgress();
            });
    }

    _setProgress(percent_complete) {
        this.progressBar.style.transform = `scale(${
            percent_complete / 100
        }, 1)`;
    }

    _hideProgress() {
        this.progressBox.classList.remove("block");
        this.progressBox.classList.add("hidden");
        this._setProgress(0);
    }

    _showProgress() {
        this.progressBox.classList.add("block");
        this.progressBox.classList.remove("hidden");
    }
}
