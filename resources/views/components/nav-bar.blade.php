<div x-data="{show: false}"
     x-init="$watch('show', val => val ? document.body.classList.add('nav-open') : document.body.classList.remove('nav-open'))"
     class="main-nav fixed top-0 w-full h-16 bg-grey-700 flex justify-between items-center px-4 z-20"
     :class="{'open': show}">
    <div class="flex items-center">
        <a href="{{ localUrl("/") }}">
            <img src="/images/logos/nav_logo.svg"
                 alt="Xterra Logo" class="h-8">
        </a>
    </div>

    <div class="flex items-center">
        @auth
            <div
                class="nav-drawer fixed lg:static top-16 left-0 w-screen min-h-screen lg:min-h-0 lg:w-auto flex flex-col lg:flex-row items-start lg:items-center bg-grey-700 z-50 pt-6 lg:pt-0">
                <a class="font-heading font-medium text-2xl lg:text-lg mx-4 text-white hover:text-red-500 uppercase"
                   href="/top-secret/campaigns">{{ trans('navbar.initiatives') }}</a>
                <div class="mx-4 event-nav">
                    <a class="font-heading font-medium text-2xl lg:text-lg text-white hover:text-red-500 uppercase flex items-center"
                       href="/top-secret/events">
                        <span>{{ trans('navbar.events') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             class="stroke-current h-4 ml-2 text-white hidden lg:block">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>

                    </a>
                    <div
                        class="event-subnav lg:absolute lg:top-16 w-screen lg:bg-tinted-dark left-0 lg:z-50 mb-4 lg:mb-0">
                        <p class="hidden lg:block pl-12 my-6 text-white type-h2">{{ trans('events.upcoming_events') }}...</p>
                        <div class="flex flex-col lg:flex-row justify-center text-white pb-2 mr-4">
                            @foreach($upcomingEvents as $event)
                                <div
                                    class="text-center px-2 lg:px-12 mt-4 mr-6 lg:mr-0 lg:ml-0 @if(!$loop->last) lg:border-r-2 border-gray-700 @endif">
                                    <p class="font-medium font-heading text-lg lg:text-2xl uppercase border-b-2 border-red-700 pr-6 lg:pl-3">
                                        <a class="hover:text-red-700"
                                           href="{{ $event['full_slug'] }}">{{ $event['name'] }}</a>

                                    </p>
                                    <div class="lg:pr-6 lg:pl-3">
                                        @foreach($event['races'] as $race)
                                            <p class="type-b2 my-2">
                                                <a href="{{ $race['full_slug'] }}" class="hover:text-red-700">
                                                    {{ $race['name'] }}
                                                </a>
                                            </p>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center my-12 hidden lg:block">
                            <a href="/top-secret/events" class="uppercase type-b2 text-white hover:text-red-700">{{ trans('navbar.all_events') }} &gt;</a>
                        </div>
                    </div>
                </div>

                <a class="font-heading font-medium text-2xl lg:text-lg mx-4 text-white hover:text-red-500 uppercase"
                   href="">{{ trans('navbar.shop') }}</a>
                <a class="font-heading font-medium text-2xl lg:text-lg mx-4 text-white hover:text-red-500 uppercase"
                   href="/">{{ trans('navbar.blog') }}</a>
                <a class="font-heading font-medium text-2xl lg:text-lg mx-4 text-white hover:text-red-500 uppercase"
                   href="">{{ trans('navbar.discover') }}</a>
                <a class="font-heading font-medium text-2xl lg:text-lg mx-4 text-white hover:text-red-500 uppercase"
                   href="">{{ trans('navbar.friends') }}</a>

            </div>
        @endauth
        <div class="flex items-center">
            <a class="mx-4 text-white no-underline hover:text-red-500 type-h3" href="{{ transUrl(Request::path()) }}">
                {{ trans('navbar.lang') }}
            </a>
            @auth
                <button @click="show = !show"
                        class="nav-trigger text-white hover:text-red-500 block lg:hidden focus:outline-none">
                    <svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                              clip-rule="evenodd"/>
                    </svg>
                </button>
            @endauth
        </div>


    </div>


</div>
