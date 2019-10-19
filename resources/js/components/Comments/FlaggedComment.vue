<template>
    <div  class="p-4 bg-white my-6">
        <p class="flex mb-6">
            <span class="mr-2 uppercase font-bold">{{ flagged.type}} </span>
            <span class="mr-2 text-gray-600"> flagged on </span>
            <span class="mr-2">{{ flagged.flagged_on }}</span>
        </p>
        <p>Originally posted by <span class="font-bold">{{ flagged.original_author }}</span></p>
        <div class="bg-gray-100 p-2 mb-6" v-html="flagged.context"></div>
        <p class="text-gray-600">Flagged by user because: </p>
        <p class="text-lg">{{ flagged.reason }}</p>
        <div class="flex justify-end mt-6">
            <button @click="$emit('dismiss-flag', flagged)" class="text-gray-600 hover:text-gray-800 font-bold">Dismiss flag</button>
            <button @click="$emit('remove-comment', flagged)" class="btn btn-dark ml-4">Remove comment</button>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        props: ['flagged']
    }
</script>
