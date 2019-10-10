<div class="max-w-sm bg-grey-300 flex flex-col justify-between mb-8 sm:mb-0">
    <div>
        <div>
            <a href="{{ localUrl('/blog/' . $post['full_slug']) }}">
                <img src="{{ $post['title_image']['thumb'] ?? '/images/default.jpg' }}"
                     alt="Cover image for {{ $post['title'] }}">
            </a>
        </div>
        <p class="type-h2 px-4 my-2">
            <a href="{{ localUrl('/blog/' . $post['full_slug']) }}">
                {{ $post['title'] }}
            </a>
        </p>
        <div class="h-1 bg-red-700 mx-4"></div>
        <div class="px-4 flex justify-between my-2">
            <p class="type-b6"><span class="type-b5">by</span> {{ $post['author_name'] }}</p>
            <p>{{ $post['publish_date'] }}</p>
        </div>
        <p class="p-4">{{ $post['intro'] }}</p>
    </div>

    <div class="flex justify-end">
        @if($post['categories'][0] ?? false)
            <a class="bg-red-500 text-white text-sm px-2 py-1 mb-4 mr-4 uppercase" href="/categories/{{ $post['categories'][0]['slug'] }}">{{ $post['categories'][0]['title']['en'] }}</a>
        @endif
    </div>
</div>