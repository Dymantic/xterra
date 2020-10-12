@if($posts)
    <div class="py-20 px-8">
        <p class="text-center type-h1 mb-12 uppercase">From The Blog</p>
        <div class="max-w-4xl mx-auto" data-flickity='{"cellAlign": "left", "contain": "true", "imagesLoaded": "true"}'>
            @foreach($posts as $post)
                @include('front.blog.post-index-card', ['post' => $post, 'classes' => 'm-6 w-full md:w-3/10 min-h-full'])
            @endforeach
        </div>
    </div>
@endif
