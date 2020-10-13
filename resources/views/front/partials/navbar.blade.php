<div class="main-nav fixed top-0 w-full h-16 bg-grey-700 flex justify-between items-center px-4">
    <div class="flex items-center">
        <a href="{{ localUrl("/") }}">
            <img src="/images/logos/nav_logo.svg"
                 alt="Xterra Logo" class="h-8">
        </a>
    </div>

    <div class="flex items-center">
        @auth
        <div class="nav-drawer fixed lg:static top-16 left-0 w-screen min-h-screen lg:min-h-0 lg:w-auto flex flex-col lg:flex-row items-start lg:items-center bg-grey-700 z-50">
            <a class="type-h3 mx-4 text-white hover:text-red-500 uppercase" href="">Initiatives</a>
            <a class="type-h3 mx-4 text-white hover:text-red-500 uppercase" href="">Events</a>
            <a class="type-h3 mx-4 text-white hover:text-red-500 uppercase" href="">Shop</a>
            <a class="type-h3 mx-4 text-white hover:text-red-500 uppercase" href="">Blog</a>
            <a class="type-h3 mx-4 text-white hover:text-red-500 uppercase" href="">Discover</a>
            <a class="type-h3 mx-4 text-white hover:text-red-500 uppercase" href="">Friends</a>

        </div>
        @endauth
        <div class="flex items-center">
            <a class="mx-4 text-white no-underline hover:text-red-500 type-h3" href="{{ transUrl(Request::path()) }}">
                {{ trans('navbar.lang') }}
            </a>
            @auth
            <button class="nav-trigger text-white hover:text-red-500 block lg:hidden focus:outline-none">
                <svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"/>
                </svg>
            </button>
            @endauth
        </div>


    </div>


</div>
