<div class="text-center type-h2 bg-red-700 px-4 lg:flex whitespace-no-wrap justify-center py-1 uppercase overflow-auto">
    <div class="mx-12 inline-block">
        <a class="text-white hover:underline {{ in_array(Request::path(), ['en', 'zh']) ? 'underline' : 'no-underline' }}"
           href="{{ localUrl('/blog') }}">{{ trans('navbar.all') }}</a>

    </div>
    @foreach($categories as $category)
        <div class="mx-12 inline-block">
            <a class="text-white hover:underline {{ \Illuminate\Support\Str::contains(Request::path(), $category['slug']) ? 'underline' : 'no-underline' }}"
               href="{{ localUrl('/categories/' . $category['slug']) }}"
            >{{ $category['name'] }}</a>
        </div>
    @endforeach
</div>
