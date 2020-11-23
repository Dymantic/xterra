<template>
    <div>
        <div class="flex justify-between items-center">
            <p class="font-bold text-lg">Event People</p>
            <find-people @selected="addPerson"></find-people>
        </div>

        <div class="my-12">
            <p class="font-bold text-lg">Ambassadors</p>
            <p class="my-6 text-gray-600" v-if="event.ambassadors.length === 0">
                There are no ambassadors attached to this event
            </p>
            <div class="flex flex-wrap">
                <campaign-person-card
                    v-for="person in event.ambassadors"
                    :person="person"
                    :relation-id="event.id"
                    relation-type="event"
                    type="ambassador"
                    :key="`ambassador_${person.id}`"
                ></campaign-person-card>
            </div>
        </div>

        <div class="my-12">
            <p class="font-bold text-lg">Coaches</p>
            <p class="my-6 text-gray-600" v-if="event.coaches.length === 0">
                There are no coaches attached to this event
            </p>
            <div class="flex flex-wrap">
                <campaign-person-card
                    v-for="person in event.coaches"
                    :person="person"
                    :relation-id="event.id"
                    relation-type="event"
                    type="coach"
                    :key="`coach_${person.id}`"
                ></campaign-person-card>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import FindPeople from "../FindPeople";
import CampaignPersonCard from "../Campaigns/CampaignPersonCard";
import { notify } from "../Messaging/notify";
export default {
    components: { FindPeople, CampaignPersonCard },

    props: ["event"],

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
            if (this.event.ambassadors.find((a) => a.id === ambassador_id)) {
                return notify.warn({ message: "Ambassador already added" });
            }
            this.$store
                .dispatch("events/attachAmbassador", {
                    event_id: this.event.id,
                    ambassador_id,
                })
                .then(() => notify.success({ message: "Ambassador added." }))
                .catch(() =>
                    notify.error({ message: "Failed to add ambassador" })
                );
        },

        addCoach(coach_id) {
            if (this.event.coaches.find((a) => a.id === coach_id)) {
                return notify.warn({ message: "Coach already added" });
            }
            this.$store
                .dispatch("events/attachCoach", {
                    event_id: this.event.id,
                    coach_id,
                })
                .then(() => notify.success({ message: "Coach added." }))
                .catch(() => notify.error({ message: "Failed to add coach" }));
        },
    },
};
</script>
