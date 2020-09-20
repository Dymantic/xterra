<template>
    <div v-if="event">
        <div class="flex justify-between items-center">
            <p class="text-lg font-bold">Prize List</p>
            <div class="flex items-center">
                <submit-button
                    @click.native="save"
                    role="button"
                    :waiting="waiting"
                    >Save</submit-button
                >
                <prize-form @added="addPrize"></prize-form>
            </div>
        </div>
        <p class="my-4 text-gray-600">
            Drag and drop into the order you want. Don't forget to save.
        </p>
        <div ref="sortList">
            <prize-item
                v-for="item in list_items"
                :key="item.id"
                :prize="item"
                @updated="updatePrize"
                @remove="deleteItem"
            >
            </prize-item>
        </div>
    </div>
</template>

<script type="text/babel">
import { PositionedList } from "../../lib/PositionedList";
import Sortable from "sortablejs";
import PrizeForm from "./PrizeForm";
import PrizeItem from "./PrizeItem";
import SubmitButton from "../Forms/SubmitButton";
import { notify } from "../Messaging/notify";
export default {
    components: {
        PrizeForm,
        PrizeItem,
        SubmitButton,
    },

    data() {
        return {
            waiting: false,
            next_id: 1,
            list: PositionedList.New(
                this.$store.state.events.current_page_event.prizes
            ),
            sortable: null,
        };
    },

    computed: {
        list_items() {
            return this.list.list.sort((a, b) => a.position - b.position);
        },

        event() {
            return this.$store.state.events.current_page_event;
        },
    },

    mounted() {
        this.sortable = new Sortable(this.$refs.sortList, {
            onSort: this.handleSort,
        });
    },

    methods: {
        handleSort(ev) {
            this.list.repositionList(this.sortable.toArray());
        },

        addPrize(prize) {
            this.list.addItem(prize);
        },

        updatePrize(prize) {
            this.list.updateItem(prize);
        },

        deleteItem(id) {
            this.list.deleteById(id);
        },

        save() {
            this.waiting = true;
            this.$store
                .dispatch("events/savePrizes", {
                    event_id: this.$route.params.id,
                    prizes: this.list.toArray(),
                })
                .then(() => notify.success({ message: "Prizes updated" }))
                .catch(() =>
                    notify.error({ message: "Failed to save prize info" })
                )
                .then(() => (this.waiting = false));
        },
    },
};
</script>
