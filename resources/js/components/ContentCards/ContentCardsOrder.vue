<template>
    <page v-if="cards">
        <page-header title="Content Cards Order">
            <router-link to="/content-cards" class="btn">Back</router-link>
        </page-header>

        <p class="max-w-lg my-10">
            Drag and drop the cards into the order you desire. Your changes will
            be saved automatically.
        </p>

        <div>
            <div class="flex flex-wrap" ref="cards">
                <div
                    v-for="card in cards"
                    :key="card.id"
                    :data-id="card.id"
                    class="relative shadow m-4 w-64"
                >
                    <div class="w-64 h-42">
                        <img
                            :src="card.image.web"
                            alt=""
                            class="w-full h-full object-cover"
                        />
                    </div>

                    <p class="uppercase p-2 font-bold">
                        {{ card.title.en }}
                    </p>
                    <p
                        class="m-2 bg-red-500 text-white absolute top-0 right-0 px-1 uppercase text-xs"
                    >
                        {{ card.category.en }}
                    </p>
                </div>
            </div>
        </div>
    </page>
</template>

<script type="text/babel">
import Page from "../Page";
import PageHeader from "../PageHeader";
import Sortable from "sortablejs";
import { notify } from "../Messaging/notify";

export default {
    components: {
        Page,
        PageHeader,
    },

    data() {
        return {
            sortable: null,
        };
    },

    computed: {
        cards() {
            return this.$store.state.cards.all;
        },
    },

    mounted() {
        this.$store
            .dispatch("cards/fetchAll")
            .catch(() => notify.error({ message: "Failed to fetch cards." }));

        this.sortable = new Sortable(this.$refs.cards, {
            onSort: this.handleSort,
        });
    },

    methods: {
        handleSort() {
            this.$store
                .dispatch("cards/setOrder", this.sortable.toArray())
                .catch(() => notify.error({ message: "Failed to save order" }));
        },
    },
};
</script>
