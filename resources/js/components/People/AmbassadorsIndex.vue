<template>
    <page>
        <page-header title="Ambassadors">
            <router-link to="/ambassadors/create" class="btn btn-dark"
                >Create Ambassador</router-link
            >
        </page-header>

        <div class="my-12">
            <div
                v-for="ambassador in ambassadors"
                :key="ambassador.id"
                class="flex items-center mb-1"
            >
                <router-link :to="`/ambassadors/${ambassador.id}/show`">
                    <div class="w-10 h-10 overflow-hidden rounded-full mr-4">
                        <img
                            :src="ambassador.profile_pic.thumb"
                            class="w-full h-full object-cover"
                        />
                    </div>
                </router-link>
                <router-link
                    :to="`/ambassadors/${ambassador.id}/show`"
                    class="hover:text-blue-600"
                >
                    <p class="w-64 truncate font-bold">
                        {{ ambassador.name.en }}
                    </p>
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
        ambassadors() {
            return this.$store.state.ambassadors.all;
        },
    },

    mounted() {
        this.$store.dispatch("ambassadors/fetch");
    },
};
</script>
