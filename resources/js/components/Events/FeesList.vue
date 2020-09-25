<template>
    <div>
        <div>
            <div class="flex justify-between">
                <p class="text-lg font-bold">Event Fees</p>
                <div class="flex items-center">
                    <submit-button
                        @click.native="save"
                        role="button"
                        :waiting="waiting"
                        >Save</submit-button
                    >
                    <fee-form @added="addFee"></fee-form>
                </div>
            </div>
            <div ref="sortList">
                <fee-item
                    v-for="item in list_items"
                    :key="item.id"
                    :fee="item"
                    @updated="updateFee"
                    @remove="removeFee"
                >
                </fee-item>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
import { PositionedList } from "../../lib/PositionedList";
import Sortable from "sortablejs";
import FeeItem from "./FeeItem";
import FeeForm from "./FeeForm";
import SubmitButton from "../Forms/SubmitButton";
import { notify } from "../Messaging/notify";

export default {
    components: {
        FeeForm,
        FeeItem,
        SubmitButton,
    },

    props: ["fees", "waiting"],

    data() {
        return {
            list: PositionedList.New(this.fees),
            sortable: null,
        };
    },

    computed: {
        list_items() {
            return this.list.list;
        },
    },

    mounted() {
        this.sortable = new Sortable(this.$refs.sortList, {
            onSort: this.handleSort,
        });
    },

    methods: {
        handleSort() {
            this.list.repositionList(this.sortable.toArray());
        },

        addFee(item) {
            this.list.addItem(item);
        },

        updateFee(item) {
            this.list.updateItem(item);
        },

        removeFee(id) {
            this.list.deleteById(id);
        },

        save() {
            this.$emit("save", this.list.toArray());
            // this.waiting = true;
            // this.$store
            //     .dispatch("events/saveFees", {
            //         event_id: this.$route.params.id,
            //         fees: this.list.toArray(),
            //     })
            //     .then(() => notify.success({ message: "Fees updated" }))
            //     .catch(() =>
            //         notify.error({ message: "Failed to save fees info" })
            //     )
            //     .then(() => (this.waiting = false));
        },
    },
};
</script>
