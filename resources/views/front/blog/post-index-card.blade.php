<div class="max-w-sm bg-grey-300 flex flex-col justify-between mb-8 sm:mb-0 {{ $classes ?? '' }} shadow-small">
    <div class="group">
        <div class="relative">
            <a href="{{ localUrl('/blog/' . $post['full_slug']) }}">
                <img src="{{ $post['title_image']['thumb'] ?? '/images/default.jpg' }}"
                     alt="Cover image for {{ $post['title'] }}" class="group-hover:opacity-75">
            </a>
            @if($post['categories'][0] ?? false)
                <a class="absolute top-0 right-0 bg-red-700 text-white text-xs px-1 mt-4 mr-4 uppercase hover:underline" href="/categories/{{ $post['categories'][0]['slug'] }}">{{ $post['categories'][0]['title']['en'] }}</a>
            @endif
        </div>
        <p class="type-h2 px-6 my-2 leading-tight">
            <a href="{{ localUrl('/blog/' . $post['full_slug']) }}" class="group-hover:text-red-700">
                {{ $post['title'] }}
            </a>
        </p>
        <div class="h-1 bg-red-700 mx-4"></div>
        <div class="px-6 flex justify-between my-2 leading-tight">
            <p class="type-b6"><span class="type-b5 mr-1 inline-block">by </span> {{ $post['author_name'] }}</p>
            <p>{{ $post['publish_date'] }}</p>
        </div>
        <p class="py-4 px-6 leading-tight">{{ $post['intro'] }}</p>
    </div>
</div>
