<template>
  <span class="border p-1">
    <button @click="show = true" class="flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" class="mr-1">
        <path d="M0 0h24v24H0z" fill="none"></path>
        <path class="fill-current text-red-500"
            d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8 12.5v-9l6 4.5-6 4.5z"
        ></path>
      </svg> Embed Video
    </button>
      <modal :show="show" @close="show = false">
            <div class="max-w-sm p-8">
          <p class="text-lg font-bold mb-6">Video Embed</p>
          <p class="text-sm my-4">Copy and paste the Youtube embed code into the box below and then click the button. To find the embed code, look for the "share" option under the video on YouTube, and then select embed.</p>
          <textarea class="form-input h-32" v-model="insertion"></textarea>
          <div class="flex justify-end mt-4">
            <button class="mr-4 hover:text-gray-800 text-gray-600" @click="show = false">Cancel</button>
            <button class="btn btn-dark" @click="doInsert">Embed Video</button>
          </div>
        </div>
      </modal>
  </span>
</template>

<script>
    import Modal from "@dymantic/modal";

    export default {

        components: {
            Modal,
        },

        props: ["trix"],
        data() {
            return {
                show: false,
                insertion: ""
            };
        },
        methods: {
            doInsert() {
                const wrapped_iframe = `<div class="aspect-16-9">${this.insertion}</div>`;
                this.trix.attachment(wrapped_iframe);
                this.show = false;
                this.insertion = "";
            }
        }
    };
</script>


