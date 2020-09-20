<template>
    <div>
        <div class="flex items-center justify-between">
            <p class="font-bold text-lg">Event Accommodation</p>
            <div class="flex items-center">
                <router-link
                    class="btn btn-dark"
                    :to="`/events/${$route.params.id}/edit/accommodation/create`"
                    >Add Accommodation</router-link
                >
            </div>
        </div>
        <div class="my-12">
            <div
                v-for="accommodation in accommodations"
                :key="accommodation.id"
                class="shadow p-6 my-6 relative"
            >
                <p class="font-bold text-lg">{{ accommodation.name.en }}</p>
                <p class="text-gray-600">{{ accommodation.name.zh }}</p>
                <div class="flex justify-between">
                    <p class="my-4 text-sm w-1/2 mr-4">
                        {{ accommodation.description.en }}
                    </p>
                    <p class="my-4 text-sm w-1/2 ml-4">
                        {{ accommodation.description.zh }}
                    </p>
                </div>

                <div class="flex justify-between text-gray-600 text-sm mt-6">
                    <span>Tel: {{ accommodation.phone }}</span>
                    <span>Link: {{ accommodation.link }}</span>
                    <span>Email: {{ accommodation.email }}</span>
                </div>
                <div class="absolute top-0 right-0 mt-4 mr-4">
                    <router-link
                        :to="`/events/${$route.params.id}/edit/accommodations/${accommodation.id}/edit`"
                        class="forn-bold hover:text-blue-600"
                        >Edit</router-link
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    computed: {
        accommodations() {
            return this.$store.getters["events/currentEventAccommodations"];
        },
    },
};
</script>
