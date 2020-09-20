<template>
    <div class="">
        <div class="flex justify-between">
            <div class="mr-8">
                <p class="font-bold">
                    {{ gallery.title.en }} |
                    <span class="text-gray-600">{{ gallery.title.zh }}</span>
                </p>
                <p class="text-sm my-4">{{ gallery.description.en }}</p>
                <p class="text-sm my-4">{{ gallery.description.zh }}</p>
            </div>
            <div>
                <div class="h-40 w-64" v-if="gallery.images.length">
                    <img
                        :src="gallery.images[0].thumb"
                        alt=""
                        class="w-full h-full object-cover"
                    />
                </div>
                <p class="text-center" v-if="gallery.images.length > 1">
                    + {{ gallery.images.length - 1 }} more
                </p>
            </div>
        </div>
    </div>
</template>

<script type="text/babel">
export default {
    props: ["gallery"],
};
</script>
