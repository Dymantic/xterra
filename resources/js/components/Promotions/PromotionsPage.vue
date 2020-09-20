<template>
    <page>
        <page-header title="Promotions">
            <router-link to="/promotions/create" class="btn btn-dark"
                >Add New Promotion</router-link
            >
        </page-header>

        <div>
            <div
                v-for="promo in promotions"
                :key="promo.id"
                class="shadow p-6 bg-white my-8 flex justify-between"
            >
                <div>
                    <p>
                        <router-link
                            :to="`/promotions/${promo.id}/show`"
                            class="font-bold hover:text-blue-600"
                            >{{ promo.title.en }} |
                            <span class="text-gray-600">{{
                                promo.title.zh
                            }}</span></router-link
                        >
                    </p>
                    <div>
                        <p class="text-sm my-3 w-80 truncate">
                            {{ promo.writeup.en }}
                        </p>
                        <p class="text-sm my-3 w-80 truncate">
                            {{ promo.writeup.zh }}
                        </p>
                    </div>
                    <div class="text-sm">
                        <span>Button: </span>
                        <span>{{ promo.button_text.en }}</span> |
                        <span>{{ promo.button_text.zh }}</span>
                    </div>
                    <p class="text-sm mt-1">
                        <span>Links to: </span>
                        <a
                            :href="promo.link"
                            class="text-blue-600 hover:underline"
                            >{{ promo.link }}</a
                        >
                    </p>
                </div>
                <div class="flex-shrink-0 flex flex-col justify-center">
                    <img :src="promo.image.thumb" class="w-64" alt="" />
                </div>
            </div>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
export default {
    components: {
        Page,
        PageHeader,
    },

    computed: {
        promotions() {
            return this.$store.state.promotions.all;
        },
    },

    mounted() {
        this.$store.dispatch("promotions/fetchAll");
    },
};
</script>
