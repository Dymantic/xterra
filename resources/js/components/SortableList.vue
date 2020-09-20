<template>
    <div ref="sortList" class="fofofofo">
        <slot :list="list"> </slot>
    </div>
</template>

<script type="text/babel">
import Sortable from "sortablejs";
import { PositionedList } from "../lib/PositionedList";

export default {
    props: ["initial"],

    data() {
        return {
            sortable: null,
            list: [],
        };
    },

    mounted() {
        this.list = PositionedList.New(this.initial);
        this.sortable = new Sortable(this.$refs.sortList, {
            onSort: this.handleSort,
        });
    },

    methods: {
        handleSort() {
            console.log(this.sortable.toArray());
            this.list = this.list.repositionList(this.sortable.toArray());
        },
    },
};
</script>
