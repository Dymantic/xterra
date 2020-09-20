<template>
    <page>
        <page-header title="Galleries">
            <router-link to="/galleries/create" class="btn btn-dark"
                >Add New Gallery</router-link
            >
        </page-header>

        <div>
            <div
                v-for="gallery in galleries"
                :key="gallery.id"
                class="my-6 shadow p-4"
            >
                <p>
                    <router-link
                        :to="`/galleries/${gallery.id}/show`"
                        class="font-bold hover:text-blue-600"
                        >{{ gallery.title.en }}</router-link
                    >
                    <span class="ml-6 text-gray-600">{{
                        gallery.title.zh
                    }}</span>
                </p>

                <div class="flex items-center text-sm text-gray-600 mt-4">
                    <svg
                        class="stroke-current h-5"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                    </svg>
                    <span class="ml-4"
                        >{{ gallery.images.length }} image(s)</span
                    >
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
        galleries() {
            return this.$store.state.galleries.all;
        },
    },

    created() {
        this.$store.dispatch("galleries/fetchGalleries");
    },
};
</script>
