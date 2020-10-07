import Vue from "vue";
import PageComments from "./components/Comments/PageComments";
import ForeignLanguageAlert from "./components/ForeignLanguageAlert";
import TagBrowser from "./front/TagBrowser";
import { initSlideShow } from "./front/slideshow";
import { initTagRevealer } from "./front/tag-revealer";

const app = new Vue({
    el: "#app",
    components: {
        PageComments,
        TagBrowser,
        ForeignLanguageAlert,
    },
});

initSlideShow();
initTagRevealer();

window.addEventListener("load", () => {
    const navTrigger = document.querySelector(".nav-trigger");
    const mainNav = document.querySelector(".main-nav");

    navTrigger.addEventListener("click", () => {
        mainNav.classList.toggle("open");
    });

    if (!document.querySelector(".article-content")) {
        return;
    }

    document.querySelectorAll(".article-content a").forEach((link) => {
        const url = new URL(link.href, window.location.origin);
        if (url.host !== window.location.host) {
            link.target = "_blank";
            link.rel = "noopener noreferrer";
        }
    });
});
