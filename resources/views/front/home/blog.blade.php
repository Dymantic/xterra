@if($posts)
    <div class="py-20 px-8">
        <p class="type-h2 mb-12 uppercase max-w-4xl mx-auto">{{ trans('homepage.blog_heading') }}</p>
        <div class="max-w-5xl mx-auto" data-flickity='{"cellAlign": "left", "contain": "true", "imagesLoaded": "true", "arrowShape": "M33.79 49.99l38.08 38.09h-5.66L28.13 49.99l38.08-38.08h5.66L33.79 49.99z"}'>
            @foreach($posts as $post)
                @include('front.blog.post-index-card', ['post' => $post, 'classes' => 'm-6 w-full md:w-3/10 my-auto'])
            @endforeach
        </div>
    </div>
@endif
