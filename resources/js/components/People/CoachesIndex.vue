<template>
    <page>
        <page-header title="Coaches">
            <router-link to="/coaches/create" class="btn btn-dark"
                >Add Coach</router-link
            >
        </page-header>

        <div class="my-12 p-6 shadow rounded-lg">
            <div
                v-for="coach in coaches"
                :key="coach.id"
                class="flex items-center mb-1"
            >
                <router-link :to="`/coaches/${coach.id}/show`">
                    <div class="w-10 h-10 overflow-hidden rounded-full mr-4">
                        <img
                            :src="coach.profile_pic.thumb"
                            class="w-full h-full object-cover"
                        />
                    </div>
                </router-link>
                <router-link
                    :to="`/coaches/${coach.id}/show`"
                    class="hover:text-blue-600"
                >
                    <p class="w-64 truncate font-bold">{{ coach.name.en }}</p>
                </router-link>
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
        coaches() {
            return this.$store.state.coaches.all;
        },
    },

    mounted() {
        this.$store.dispatch("coaches/fetch");
    },
};
</script>
