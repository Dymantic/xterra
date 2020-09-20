class PositionedList {
    constructor() {
        this.next_id = 1;
        this.list = [];
    }

    getNextId() {
        const next = this.next_id;
        this.next_id++;
        return next;
    }

    addItem(item) {
        item.id = this.getNextId();
        item.position = this.list.length + 1;
        this.list.push(item);
    }

    updateItem(item) {
        const in_list = this.list.find((i) => i.id === item.id);
        Object.keys(item).forEach((key) => {
            if (key !== "id") {
                in_list[key] = item[key];
            }
        });
    }

    deleteById(id) {
        this.list = this.list.filter((item) => item.id !== id);
    }

    toArray() {
        return this.list.map((item) =>
            Object.keys(item).reduce((pruned, key) => {
                if (key !== "id") {
                    pruned[key] = item[key];
                }
                return pruned;
            }, {})
        );
    }

    repositionList(ids) {
        const new_list = ids.map((id, index) => {
            const item = this.list.find((it) => it.id === parseInt(id));
            item.position = index + 1;
            return item;
        });

        this.list = new_list;
    }

    static New(list) {
        const positioned_list = new PositionedList();
        PositionedList.sortByPosition(list).forEach((item) =>
            positioned_list.addItem(item)
        );
        return positioned_list;
    }

    static sortByPosition(unsorted) {
        return unsorted.sort((a, b) => a.position - b.position);
    }
}

export { PositionedList };
