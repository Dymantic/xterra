@extends('front.base')

@section('content')
    @if(($slideshow ?? false) && ($page === 1))
        @include('front.partials.slide-show')
    @endif
    @include('front.partials.categories-nav')

    @if($page_title ?? false)
    <div>
        <h1 class="my-16 type-h1 text-center px-4 uppercase">{{ $page_title }}</h1>
    </div>
    @endif

    @if($tag_title ?? false)
        <div class="my-16 text-center">
            <p class="type-b4 text-grey-500">Tag</p>
            <h1 class="type-h4 px-4 uppercase">{{ $tag_title }}</h1>
        </div>
    @endif


    <div class="{{ $tag_title ?? false ? 'article-simple-grid' : 'article-grid' }} max-w-4xl mx-auto">
        @foreach($posts['posts'] as $post)
            @include('front.blog.post-index-card', ['post' => $post])
        @endforeach
    </div>

    @if(count($posts['posts']) < 1)
        @if($tag_title ?? false)
            <p class="mx-4 p-8 bg-grey-200 text-xl max-w-lg mx-auto">{{ trans('blog-index.no_match_tag') }}</p>
        @else
            <p class="mx-4 p-8 bg-grey-200 text-xl max-w-lg mx-auto">{{ trans('blog-index.no_match_category') }}</p>
        @endif

    @endif


    <div class="max-w-xl mx-auto flex justify-around my-12">
        @if($posts['has_previous'])
            <div><a class="type-b6 uppercase" href="{{ '?page=' . $posts['previous_page'] }}">&lang; {{ trans('blog-index.previous_page') }}</a></div>
        @endif
        @if($posts['has_next'])
        <div><a class="type-b6 uppercase" href="{{ '?page=' . $posts['next_page'] }}">{{ trans('blog-index.next_page') }} &rang;</a></div>
        @endif
    </div>

    @if($all_tags ?? false)
    <tag-browser :tags="{{ $all_tags }}" class="px-4"></tag-browser>
    @endif
@endsection
