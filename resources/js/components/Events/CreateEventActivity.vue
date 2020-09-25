<template>
    <div>
        <p class="font-bold text-lg mb-6">Add a new Race or Activity</p>
        <event-activity-form></event-activity-form>
    </div>
</template>

<script type="text/babel">
import EventActivityForm from "./EventActivityForm";
export default {
    components: {
        EventActivityForm,
    },
};
</script>
