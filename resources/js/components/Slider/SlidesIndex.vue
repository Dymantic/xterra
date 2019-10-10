<template>
    <div class="max-w-4xl mx-auto">
        <section class="flex justify-between items-center py-8">
            <h1 class="flex-1 text-5xl font-bold">Homepage Slider</h1>
            <div class="flex justify-end items-center">

            </div>
        </section>
        <div class="my-8 p-4 bg-white shadow-lg flex items-center">
            <p>How many slides should show on the home page?</p>
            <div class="flex ml-8" :class="{'opacity-50': is_syncing}">
                <div v-for="number in length_options"
                     :key="number"
                     @click="setSlideCount(number)"
                     class="w-8 h-8 mx-2 rounded-full flex justify-center items-center hover:text-white hover:bg-blue-700 cursor-pointer"
                     :class="number > current_slide_count ? 'bg-gray-300' : 'bg-blue-300'"
                >{{ number }}
                </div>
            </div>
            <span class="ml-6 italic text-gray-600 text-sm" v-if="is_syncing">Syncing</span>
        </div>
        <div>
            <slide-index-card :slide="first_slide"
                              :position="1"></slide-index-card>
            <slide-index-card :slide="second_slide"
                              :position="2"></slide-index-card>
            <slide-index-card :slide="third_slide"
                              :position="3"></slide-index-card>
            <slide-index-card :slide="fourth_slide"
                              :position="4"></slide-index-card>
            <slide-index-card :slide="fifth_slide"
                              :position="5"></slide-index-card>
            <slide-index-card :slide="sixth_slide"
                              :position="6"></slide-index-card>
        </div>
    </div>
</template>

<script type="text/babel">
    import SlideIndexCard from "./SliderIndexCard";
    import {notify} from "../Messaging/notify";

    export default {

        components: {
            SlideIndexCard,
        },

        data() {
            return {
                syncing: false,
                length_options: [1, 2, 3, 4, 5, 6],
            };
        },

        computed: {
            first_slide() {
                return this.$store.getters['slider/byPosition'](1);
            },

            second_slide() {
                return this.$store.getters['slider/byPosition'](2);
            },

            third_slide() {
                return this.$store.getters['slider/byPosition'](3);
            },

            fourth_slide() {
                return this.$store.getters['slider/byPosition'](4);
            },

            fifth_slide() {
                return this.$store.getters['slider/byPosition'](5);
            },

            sixth_slide() {
                return this.$store.getters['slider/byPosition'](6);
            },

            current_slide_count() {
                return this.$store.state.slider.slide_count;
            },

            is_syncing() {
                return this.syncing || (this.current_slide_count === null);
            }
        },

        mounted() {
            this.$store.dispatch('slider/fetch')
                .catch(notify.error);
            this.$store.dispatch('slider/getSlideCount')
                .catch(notify.error);
        },

        methods: {
            setSlideCount(count) {
                if(this.syncing) {
                    return;
                }
                this.syncing = true;
                this.$store.dispatch('slider/setSlideCount', count)
                    .catch(notify.error)
                    .then(() => this.syncing = false);
            }
        }
    }
</script>