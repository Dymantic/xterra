<template>
    <span>
        <button class="btn btn-dark" @click="showFinder = true">
            Find People
        </button>
        <modal :show="showFinder" @close="showFinder = false">
            <div class="p-6 max-w-lg w-screen">
                <p class="font-bold text-lg mb-4">Search People By Name</p>
                <input type="text" v-model="query" class="form-input" />

                <div class="mt-6 h-64 overflow-auto">
                    <div
                        v-for="match in matches"
                        :key="`${match.type}_${match.id}`"
                        class="flex items-center justify-between"
                    >
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 rounded-full overflow-hidden mr-3"
                            >
                                <img
                                    :src="match.avatar"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                            <p class="font-semibold text-sm mr-4">
                                {{ match.name }}
                            </p>
                            <colour-label
                                :colour="
                                    match.type === 'coach' ? 'orange' : 'purple'
                                "
                                :text="match.type"
                            ></colour-label>
                        </div>
                        <div>
                            <button
                                class="font-bold text-gray-600 hover:text-blue"
                                @click="selectPerson(match)"
                            >
                                Select
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
import Modal from "@dymantic/modal";
import ColourLabel from "./ColourLabel";
export default {
    components: { ColourLabel, Modal },

    data() {
        return {
            showFinder: false,
            query: "",
        };
    },

    computed: {
        ambassadors() {
            return this.$store.state.ambassadors.all;
        },

        coaches() {
            return this.$store.state.coaches.all;
        },

        matches() {
            if (this.query.length < 3) {
                return [];
            }

            const ams = this.ambassadors
                .filter(
                    (a) =>
                        a.name.en
                            .toLowerCase()
                            .includes(this.query.toLowerCase()) ||
                        a.name.zh
                            .toLowerCase()
                            .includes(this.query.toLowerCase())
                )
                .map((a) => ({
                    type: "ambassador",
                    name: `${a.name.en} | ${a.name.zh}`,
                    id: a.id,
                    avatar: a.profile_pic.thumb,
                }));
            const cos = this.coaches
                .filter(
                    (a) =>
                        a.name.en
                            .toLowerCase()
                            .includes(this.query.toLowerCase()) ||
                        a.name.zh
                            .toLowerCase()
                            .includes(this.query.toLowerCase())
                )
                .map((c) => ({
                    type: "coach",
                    name: `${c.name.en} | ${c.name.zh}`,
                    id: c.id,
                    avatar: c.profile_pic.thumb,
                }));

            return [...ams, ...cos];
        },
    },

    mounted() {
        this.$store.dispatch("ambassadors/fetch");
        this.$store.dispatch("coaches/fetch");
    },

    methods: {
        selectPerson(person) {
            this.$emit("selected", person);
            this.query = "";
            this.showFinder = false;
        },
    },
};
</script>
