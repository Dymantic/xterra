function setValidationErrors(bag, errors) {
    return Object.keys(bag).reduce((new_bag, key) => {
        if (errors.hasOwnProperty(key)) {
            new_bag[key] = errors[key][0];
            return new_bag;
        }
        new_bag[key] = "";
        return new_bag;
    }, {});
}

function clearValidationErrors(bag) {
    return Object.keys(bag).reduce((new_bag, key) => {
        new_bag[key] = "";
        return new_bag;
    }, {});
}

export { setValidationErrors, clearValidationErrors };
