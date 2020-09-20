function toStandardDateString(date) {
    const y = date.getFullYear();
    const m = date.getMonth() + 1;
    const d = date.getDate();

    return `${y}-${pad(m)}-${pad(d)}`;
}

function pad(number) {
    return number < 10 ? `0${number}` : number;
}

export { toStandardDateString };
