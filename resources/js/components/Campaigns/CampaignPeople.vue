<template>
    <div>
        <div class="flex justify-between items-center">
            <p class="text-lg font-bold">Campaign People</p>
            <find-people @selected="addPerson"></find-people>
        </div>

        <div class="my-12">
            <p class="font-bold text-lg">Ambassadors</p>
            <p
                class="my-6 text-gray-600"
                v-if="campaign.ambassadors.length === 0"
            >
                There are no ambassadors attached to this campaign
            </p>
            <div class="flex flex-wrap">
                <campaign-person-card
                    v-for="person in campaign.ambassadors"
                    :person="person"
                    :relation-id="campaign.id"
                    relation-type="campaign"
                    type="ambassador"
                    :key="`ambassador_${person.id}`"
                ></campaign-person-card>
            </div>
        </div>

        <div class="my-12">
            <p class="font-bold text-lg">Coaches</p>
            <p class="my-6 text-gray-600" v-if="campaign.coaches.length === 0">
                There are no coaches attached to this campaign
            </p>
            <div class="flex flex-wrap">
                <campaign-person-card
                    v-for="person in campaign.coaches"
                    :person="person"
                    :relation-id="campaign.id"
                    relation-type="campaign"
                    type="coach"
                    :key="`coach_${person.id}`"
                ></campaign-person-card>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import FindPeople from "../FindPeople";
import { notify } from "../Messaging/notify";
import CampaignPersonCard from "./CampaignPersonCard";
export default {
    components: { CampaignPersonCard, FindPeople },

    props: ["campaign"],

    computed: {},

    methods: {
        addPerson({ id, type }) {
            if (type === "ambassador") {
                return this.addAmbassador(id);
            }

            if (type === "coach") {
                return this.addCoach(id);
            }
        },

        addAmbassador(ambassador_id) {
            if (this.campaign.ambassadors.find((a) => a.id === ambassador_id)) {
                return notify.warn({ message: "Ambassador already added" });
            }
            this.$store
                .dispatch("campaigns/attachAmbassador", {
                    campaign_id: this.campaign.id,
                    ambassador_id,
                })
                .then(() => notify.success({ message: "Ambassador added." }))
                .catch(() =>
                    notify.error({ message: "Failed to add ambassador" })
                );
        },

        addCoach(coach_id) {
            this.$store
                .dispatch("campaigns/attachCoach", {
                    campaign_id: this.campaign.id,
                    coach_id,
                })
                .then(() => notify.success({ message: "Coach added." }))
                .catch(() => notify.error({ message: "Failed to add coach" }));
        },
    },
};
</script>
