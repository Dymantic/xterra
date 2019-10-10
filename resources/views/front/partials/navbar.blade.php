<div class="fixed top-0 w-full h-16 bg-grey-700 flex justify-between items-center px-4">
    <div class="flex items-center">
        <a href="/en">
            <img src="/images/logos/small.png"
                 alt="Xterra Logo" class="pr-2 mr-2 border-r border-white">
        </a>
        <span class="type-h2 text-white uppercase">Taiwan</span>
    </div>

    <div class="flex items-center">
        <a class="text-white no-underline hover:text-red-500 type-h3" href="{{ transUrl(Request::path()) }}">
            {{ trans('navbar.lang') }}
        </a>
    </div>
</div>
