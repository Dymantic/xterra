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
                <p class="uppercase type-h2 text-center">{{ trans('footer.subscribe') }}</p>
                <p class="type-b1 w-64 text-center">{{ trans('footer.subscribe_blurb') }}</p>
                <div class="flex items-stretch w-9/10 mt-3">
                    <input type="text" name="subscribe_email" class="focus:outline-none bg-gray-500 rounded-l-lg p-2 flex-1">
                    <button class="bg-gray-500 text-black type-h2 uppercase rounded-r-lg ml-1 px-6 hover:text-red-700">{{ trans('footer.subscribe_button') }}</button>
                </div>
            </div>
        </div>
        <div class="pb-2">
            <p class="text-center type-b3">{{ trans('footer.all_rights') }}</p>
        </div>

    </footer>
@endauth
