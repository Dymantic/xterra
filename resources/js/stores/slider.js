import axios from "axios";
import {notify} from "../components/Messaging/notify";

export default {
    namespaced: true,

    state: {
        set_slides: [],
        slide_count: null,
    },

    getters: {

        byPosition: state => position => {
            return state.set_slides.find(slide => parseInt(slide.position) === parseInt(position));
        }
    },

    actions: {

        getSlideCount({state}) {
            return new Promise((resolve, reject) => {
               axios.get("/admin/site-settings/slide-count")
                   .then(({data}) => state.slide_count = data.slide_count)
                   .catch(() => reject({message: 'Unable to get slide count'}));
            });
        },

        setSlideCount({state}, slide_count) {
            return new Promise((resolve, reject) => {
                axios.post("/admin/site-settings/slide-count", {slide_count})
                    .then(({data}) => {
                        state.slide_count = data.slide_count;
                        resolve();
                    })
                    .catch(() => reject({message: 'Unable to set slide limit'}));
            });
        },

        fetch({state}) {
            return new Promise((resolve, reject) => {
                axios.get("/admin/slider/slides")
                     .then(({data}) => {
                         state.set_slides = data;
                         resolve();
                     })
                     .catch(() => reject({message: 'Unable to fetch slides'}));
            });
        },

        setArticleForSlide({dispatch}, {position, article_id}) {
            return new Promise((resolve, reject) => {
                axios.post("/admin/slider/slides", {position, article_id})
                     .then(() => {
                         dispatch('fetch')
                             .catch(() => notify.error({message: 'Unable to fetch slides'}));
                         resolve({message: `Slide has been set for position ${position}`});
                     })
                     .catch(() => reject({message: `Unable to set slide for position ${position}`}))
            });
        },

        clearSlide({dispatch}, position) {
            return new Promise((resolve, reject) => {
                axios.delete(`/admin/slider/${position}`)
                    .then(() => {
                        dispatch('fetch')
                            .catch(notify.error({message: 'Unable to fetch slides'}));
                        resolve({message: `Slide at position ${position} cleared`});
                    })
                    .catch(() => reject({message: `Unable to clear slide at position ${position}`}));
            });
        }
    }
}