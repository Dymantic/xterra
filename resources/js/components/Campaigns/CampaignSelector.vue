<template>
    <span>
        <button @click="showModal = true" class="btn btn-dark">
            Select Campaign
        </button>
        <modal :show="showModal" @close="showModal = false">
            <div class="max-w-xl w-screen p-6">
                <p class="font-bold text-lg mb-6">Select a Campaign</p>
                <div>
                    <input-field
                        label="Search"
                        placeholder="Filter by English name"
                        v-model="search"
                    ></input-field>
                </div>
                <div class="h-80 pt-6 overflow-auto">
                    <div
                        v-for="campaign in options"
                        :key="campaign.id"
                        class="border-b border-gray-300 flex justify-between items-center p-2 my-4"
                    >
                        <div>
                            <p class="font-bold mb-1">
                                {{ campaign.title.en }}
                            </p>
                        </div>
                        <button
                            class="font-bold text-sm hover:text-blue-600"
                            @click="selectCampaign(campaign)"
                        >
                            Select
                        </button>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="button" class="btn" @click="close">
                        Cancel
                    </button>
                </div>
            </div>
        </modal>
    </span>
</template>

<script type="text/babel">
import Modal from "@dymantic/modal";
import InputField from "../Forms/InputField";

export default {
    components: {
        InputField,
    },

    data() {
        return {
            showModal: false,
            search: "",
        };
    },

    computed: {
        campaigns() {
            return this.$store.state.campaigns.all;
        },

        options() {
            if (this.search === "") {
                return this.campaigns;
            }
            return this.campaigns.filter((campaign) =>
                campaign.title.en
                    .toLowerCase()
                    .includes(this.search.toLowerCase())
            );
        },
    },

    created() {
        this.$store.dispatch("campaigns/fetchAll");
    },

    methods: {
        selectCampaign(event) {
            this.$emit("campaign-selected", event);
            this.close();
        },

        close() {
            this.search = "";
            this.showModal = false;
        },
    },
};
</script>
