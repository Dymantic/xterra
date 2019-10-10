<template>
    <span>
        <span class="text-white bg-red-300 text-xs rounded uppercase font-bold tracking-wide px-1" v-if="!translation.is_published">Draft</span>
        <span class="text-white bg-orange-300 text-xs rounded uppercase font-bold tracking-wide px-1" v-if="translation.is_published && !translation.is_live">Sched</span>
        <span class="text-white bg-green-400 text-xs rounded uppercase font-bold tracking-wide px-1" v-if="translation.is_live">Live</span>
        <span v-if="showDate && translation.is_published" class="ml-4 text-sm text-gray-600">{{ translation.publish_date }}</span>
    </span>
</template>

<script type="text/babel">
    export default {
        props: ['translation', 'show-date'],
    }
</script>

