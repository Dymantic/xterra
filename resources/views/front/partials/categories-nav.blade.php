<div class="text-center bg-red-500 px-4 lg:flex whitespace-no-wrap justify-around py-1 uppercase overflow-auto">
    <div class="mx-8 inline-block">
        <a class="type-h2 text-white hover:underline {{ in_array(Request::path(), ['en', 'zh']) ? 'underline' : 'no-underline' }}"
           href="{{ localUrl('/') }}">{{ trans('navbar.all') }}</a>

    </div>
    @foreach($categories as $category)
        <div class="mx-8 inline-block">
            <a class="type-h2 text-white hover:underline {{ \Illuminate\Support\Str::contains(Request::path(), $category['slug']) ? 'underline' : 'no-underline' }}"
               href="{{ localUrl('/categories/' . $category['slug']) }}"
            >{{ $category['name'] }}</a>
        </div>
    @endforeach
</div>
