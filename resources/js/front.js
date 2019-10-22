import Vue from "vue";
import PageComments from "./components/Comments/PageComments";
import ForeignLanguageAlert from "./components/ForeignLanguageAlert";
import TagBrowser from "./front/TagBrowser";
import {initSlideShow} from "./front/slideshow";
import {initTagRevealer} from "./front/tag-revealer";

const app = new Vue({
    el: '#app',
    components: {
        PageComments,
        TagBrowser,
        ForeignLanguageAlert,
    }
});

initSlideShow();
initTagRevealer();
