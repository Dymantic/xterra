<template>
    <span class="border p-1">
        <button @click="show = true" class="ml-2 border-l-8 border-red-700 px-2 type-b6">Highlight</button>
        <modal :show="show" @close="show = false">
            <div class="max-w-sm p-8">
          <p class="text-lg font-bold mb-6">Text Highlight</p>
          <p class="text-sm my-4">Text inserted here will be styled to bring it more attention. It is a good way to start off an article.</p>
          <textarea class="form-input h-32" v-model="insertion"></textarea>
          <div class="flex justify-end mt-4">
            <button class="mr-4 hover:text-gray-800 text-gray-600" @click="show = false">Cancel</button>
            <button class="btn btn-dark" @click="insert">Insert Highlight</button>
          </div>
        </div>
        </modal>
    </span>
</template>

<script type="text/babel">
    import Modal from "@dymantic/modal";

    export default {

        components: {
            Modal,
        },

        props: ['trix'],

        data() {
            return {
                show: false,
                insertion: '',
            };
        },

        methods: {
            insert() {
                this.trix.attachment(`<div class="highlight">${this.insertion}</div>`);
                this.insertion = "";
                this.show = false;
            }
        }
    }
</script>
