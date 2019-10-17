<div class="fixed top-0 w-full h-16 bg-grey-700 flex justify-between items-center px-4">
    <div class="flex items-center">
        <a href="/en">
            <img src="/images/logos/nav_logo.svg"
                 alt="Xterra Logo" class="h-8">
        </a>
    </div>

    <div class="flex items-center">
        <a class="text-white no-underline hover:text-red-500 type-h3" href="{{ transUrl(Request::path()) }}">
            {{ trans('navbar.lang') }}
        </a>
    </div>
</div>
