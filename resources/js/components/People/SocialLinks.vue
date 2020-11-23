<template>
    <div>
        <p class="font-bold text-lg mb-3">Social links</p>
        <div
            v-for="link in links"
            :key="link.platform"
            class="flex items-center mb-1"
        >
            <p class="font-bold mr-2 capitalize">{{ link.platform }}</p>
            <a
                :href="link.link"
                target="_blank"
                rel="nofollow"
                class="text-blue-600 hover:underline text-sm"
                >{{ link.link }}</a
            >
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["links"],
};
</script>
