@guest
    <footer class="bg-grey-700 px-8 py-12 text-white">
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
            <a target="_blank" href="https://www.youtube.com/channel/UCSd_AkAxmxIIy2Hd8YJz4kQ" rel="noreferrer nofollow"
               class="text-white hover:text-red-500 mx-4">
                @include('svg.social-icons.youtube', ['classes' => 'fill-current h-5'])
            </a>
        </div>
        <div class="text-center mt-8">
            <a class="type-h3 uppercase hover:text-red-500" href="http://www.xterrataiwan.com/" target="_blank"
               rel="noreferrer nofollow">www.xterrataiwan.com</a>
        </div>

    </footer>
@endguest

@auth
    <footer class="bg-grey-700 text-white">
        <div class="py-12">
            <img src="/images/logos/nav_logo.svg" alt="XTERRA Taiwan logo" class="w-48 mx-auto" width="300px"
                 height="71px">
        </div>
        <div class="pb-12 px-6 flex flex-col-reverse lg:flex-row">
            <div class="w-full lg:w-1/3 mb-8 lg:mb-0">
                <p class="uppercase type-h2 text-center">{{ trans('footer.quick_links') }}</p>
                <div class="grid grid-cols-2 place-content-center w-64 mx-auto mt-4">
                    <a class="type-b3 hover:text-red-700 mx-auto"
                       href="{{ localUrl('/top-secret/events') }}">{{ trans('navbar.events') }}</a>
                    <a class="type-b3 hover:text-red-700 mx-auto"
                       href="{{ localUrl('/top-secret/campaigns') }}">{{ trans('navbar.initiatives') }}</a>
                    <a class="type-b3 hover:text-red-700 mx-auto" href="{{ localUrl('') }}"
                       target="_blank">{{ trans('navbar.shop') }}</a>
                    <a class="type-b3 hover:text-red-700 mx-auto"
                       href="{{ localUrl('/top-secret/blog') }}">{{ trans('navbar.blog') }}</a>
                    <a class="type-b3 hover:text-red-700 mx-auto"
                       href="{{ localUrl('/top-secret/friends') }}">{{ trans('navbar.friends') }}</a>
                </div>
            </div>
            <div class="w-full lg:w-1/3 mb-8 lg:mb-0">
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
            <div class="w-full lg:w-1/3 mb-8 lg:mb-0 flex flex-col items-center">

                <div x-data="newsletter()" class="w-full h-64">

                    <form @submit.prevent="subscribe"  class="w-9/10 mt-3 max-w-sm" x-show="!complete">
                        <p class="text-center uppercase type-h2 text-center">{{ trans('footer.subscribe') }}</p>
                        <p class="text-center type-b1 w-64 mx-auto text-center">{{ trans('footer.subscribe_blurb') }}</p>
                        <div>
                            <label class="type-b3" for="">Email Address</label>
                            <input required x-model="email" type="email" name="subscribe_email" class="block w-full mb-1 bg-grey-700 border border-gray-500 p-1 rounded flex-1" placeholder="Your email address">
                        </div>
                        <div>
                            <label class="type-b3" for="">Your name</label>
                            <input x-model="name" type="text" name="subscribe_email" class="block w-full bg-grey-700 border border-gray-500 rounded flex-1 p-1" placeholder="Your name">
                        </div>
                        <div class="flex justify-center mt-2">
                            <button :class="{'bg-gray-500 hover:bg-white': !waiting}" class="text-black type-h2 uppercase rounded ml-1 px-6" :disabled="waiting">
                                <span x-show="!waiting">{{ trans('footer.subscribe_button') }}</span>
                                <span x-show="waiting" class="text-white">....</span>
                            </button>
                        </div>
                    </form>
                    <div>
                        <p class="type-h3 text-center" x-text="message" x-show="complete"></p>
                    </div>
                </div>

            </div>
        </div>
        <div class="pb-2">
            <p class="text-center type-b3">{{ trans('footer.all_rights') }}</p>
        </div>
    </footer>

    <script>
        function newsletter() {
            return {
                name: '',
                email: '',
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
                            this.message = 'Something went wrong, please refresh and retry.'
                            this.complete = true;
                        });
                },
                handleResponse(response) {
                    console.log(this);
                    this.success = response.subscribed;
                    this.message = response.message;
                    this.complete = true;
                }
            };

        }


    </script>
@endauth
