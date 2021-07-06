<footer class="bg-grey-700 text-white">
    <div class="py-12 flex justify-center">
        <a href="{{ localUrl("/") }}">
            @include('svg.xterra_wordmark', ['classes' => 'text-white h-4 hover:text-red-700'])
        </a>

    </div>
    <div class="pb-12 px-6 flex flex-col lg:flex-row">
        <div class="w-full lg:w-1/3 mb-8 lg:mb-0 order-3 lg:order-1">
            <p class="uppercase type-h2 text-center">{{ trans('footer.quick_links') }}</p>
            <div class="grid grid-cols-2 place-content-center w-64 mx-auto mt-4">
                <a class="type-b3 hover:text-red-700 mx-auto"
                   href="{{ localUrl('/events') }}">{{ trans('navbar.events') }}</a>
                <a class="type-b3 hover:text-red-700 mx-auto"
                   href="{{ localUrl('/initiatives') }}">{{ trans('navbar.initiatives') }}</a>
                <a class="type-b3 hover:text-red-700 mx-auto" href="https://shop.xterrataiwan.com/"
                   target="_blank">{{ trans('navbar.shop') }}</a>
                <a class="type-b3 hover:text-red-700 mx-auto"
                   href="{{ localUrl('/blog') }}">{{ trans('navbar.blog') }}</a>
                {{--                    <a class="type-b3 hover:text-red-700 mx-auto"--}}
                {{--                       href="{{ localUrl('/friends') }}">{{ trans('navbar.friends') }}</a>--}}
                <a class="type-b3 hover:text-red-700 mx-auto"
                   href="{{ localUrl('/privacy-policy') }}">{{ trans('footer.privacy') }}</a>
            </div>
        </div>
        <div class="w-full lg:w-1/3 mb-8 lg:mb-0 order-2 lg:order-3">
            <p class="uppercase type-h2 text-center">{{ trans('footer.follow') }}</p>
            <div class="flex justify-center my-4">
                <a target="_blank" href="https://facebook.com/xterrataiwan" rel="noreferrer nofollow"
                   class="text-white hover:text-red-500 mx-4">
                    @include('svg.social-icons.facebook', ['classes' => 'fill-current h-5'])
                </a>
                <a target="_blank" href="https://www.instagram.com/xterra_taiwan/" rel="noreferrer nofollow"
                   class="text-white hover:text-red-500 mx-4">
                    @include('svg.social-icons.instagram', ['classes' => 'fill-current h-5'])
                </a>
                <a target="_blank" href="mailto:info@xterrataiwan.com" rel="noreferrer nofollow"
                   class="text-white hover:text-red-500 mx-4">
                    @include('svg.social-icons.email', ['classes' => 'fill-current h-5'])
                </a>
                <a target="_blank" href="https://www.youtube.com/channel/UCSd_AkAxmxIIy2Hd8YJz4kQ"
                   rel="noreferrer nofollow" class="text-white hover:text-red-500 mx-4">
                    @include('svg.social-icons.youtube', ['classes' => 'fill-current h-5'])
                </a>
            </div>
        </div>
        <div class="w-full lg:w-1/3 mb-8 lg:mb-0 flex flex-col items-center order-1 lg:order-2">

            <div x-data="newsletter()" class="w-full h-64">

                <form @submit.prevent="subscribe" class="w-9/10 max-w-sm mx-auto" x-show="!complete">
                    <p class="text-center uppercase type-h2 text-center">{{ trans('footer.subscribe') }}</p>
                    <p class="text-center type-b3 w-64 mx-auto text-center">{{ trans('footer.subscribe_blurb') }}</p>
                    <div>
                        <input required x-model="email" type="email" name="subscribe_email"
                               class="block w-full mb-1 bg-grey-700 border border-gray-500 p-1 rounded flex-1"
                               placeholder="{{ trans('footer.email_placeholder') }}">
                    </div>
                    <div>
                        <input x-model="name" type="text" name="subscribe_email"
                               class="block w-full bg-grey-700 border border-gray-500 rounded flex-1 p-1"
                               placeholder="{{trans('footer.name_placeholder')}}">
                    </div>
                    <div class="flex justify-center mt-2">
                        <button class="type-b2 uppercase rounded p-2" :disabled="waiting || email === ''">
                            <span x-show="!waiting" :class="{'hover:text-red-700': email !== ''}">{{ trans('footer.subscribe_button') }} &gt;</span>
                            <span x-show="waiting" class="text-white">....</span>
                        </button>
                    </div>
                </form>
                <div>
                    <div x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-50"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-50" class="type-h3 text-center"
                         x-show="complete">
                        <p x-show="success" class="text-center uppercase type-h2 text-center mb-4">{{ trans('footer.subscribe_heading_success') }}</p>
                        <p x-show="!success" class="text-center uppercase type-h2 text-center mb-4">{{ trans('footer.subscribe_heading_error') }}</p>
                        <p x-text="message"></p>
                        <div class="text-center py-4" x-show="success">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 class="stroke-current h-8 mx-auto transform rotate-45">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>

                        </div>
                        <div class="text-center py-4" x-show="!success">
                            <button @click="resetForm">{{ trans('footer.subscribe_retry') }}</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="pb-2">
        <p class="text-center type-b3">
            {{ trans('footer.all_rights') }}. Beautifully Built by <a class="hover:text-teal"
                                                                      href="https://dymanticdesign.com">Dymantic
                Design.</a>
        </p>
    </div>
</footer>

<script>
    function newsletter() {
        return {
            name: '',
            email: '',
            success: false,
            waiting: false,
            complete: false,
            message: '',
            subscribe() {
                this.waiting = true;
                const fd = new FormData();
                fd.append('name', this.name);
                fd.append('email', this.email);
                fd.append('_token', '{{ csrf_token() }}');
                return fetch("/newsletter/subscribe", {
                    method: 'POST',
                    body: fd,
                }).then(response => response.json())
                  .then((data) => this.handleResponse(data))
                  .catch(() => {
                      this.waiting = false;
                      this.message = "{{ trans('footer.subscribe_error') }}";
                      this.complete = true;
                  });
            },
            handleResponse(response) {
                this.success = response.subscribed;
                this.message = response.message;
                this.complete = true;
            },
            resetForm() {
                this.name = '';
                this.email = '';
                this.success = false;
                this.waiting = false;
                this.complete = false;
                this.message = '';
            }
        };

    }


</script>
