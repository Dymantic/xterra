<div class="w-48 md:w-64 inline-block mr-8 md:mr-0 align-top group">
    <div class="relative">
        <a href="{{ localUrl('/blog/' . $post['full_slug']) }}">
            <img src="{{ $post['title_image']['thumb'] ?? '/images/default.jpg' }}"
                 alt="Cover image for {{ $post['title'] }}" class="group-hover:opacity-75">
        </a>

    </div>
    <p class="type-h3 whitespace-normal leading-tight">
        <a href="{{ localUrl('/blog/' . $post['full_slug']) }}" class="group-hover:text-red-700">
            {{ $post['title'] }}
        </a>
    </p>
</div>
