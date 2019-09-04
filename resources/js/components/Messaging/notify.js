import { EventBus } from "./EventBus";

const notify = {
    success(alert) {
        EventBus.$emit("notify:success", alert);
    },

    error(alert) {
        EventBus.$emit("notify:error", alert);
    },

    warn(alert) {
        EventBus.$emit("notify:warning", alert);
    }
};

export {notify};