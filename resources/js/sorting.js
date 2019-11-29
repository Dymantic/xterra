function sortByStringProp(property) {
    return (a,b) => {
        const valA = a[property].toUpperCase();
        const valB = b[property].toUpperCase();

        if(valA > valB) {
            return 1;
        }

        if(valB > valA) {
            return -1;
        }

        return 0;
    }
}

export {sortByStringProp};
