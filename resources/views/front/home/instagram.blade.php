@if(count($ig_posts))
<div>
    <div class="flex items-stretch">
        <div class="w-half-screen h-half-screen flex-shrink-0 relative group">
            @include('front.home.ig-post', ['ig_post' => $ig_posts[0]])
        </div>
        <div class="flex flex-col">
            <div class="flex flex-1">
                <div class="w-1/2 group relative">
                    @include('front.home.ig-post', ['ig_post' => $ig_posts[1]])
                </div>
                <div class="w-1/2 group relative">
                    @include('front.home.ig-post', ['ig_post' => $ig_posts[2]])
                </div>
            </div>
            <div class="flex flex-1">
                <div class="w-1/2 group relative">
                    @include('front.home.ig-post', ['ig_post' => $ig_posts[3]])
                </div>
                <div class="w-1/2 group relative">
                    @include('front.home.ig-post', ['ig_post' => $ig_posts[4]])
                </div>
            </div>
        </div>
    </div>
</div>
@endif
