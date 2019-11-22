@extends('front.base')

@section('title')
    {{ $article['title'] }}
@endsection

@section('head')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <link rel="canonical" href="{{ url($article['canonical_url']) }}" />

    @if($article['alternatives'] ?? false)
    @foreach($article['alternatives'] as $trans)
        <link rel="alternate" hreflang="{{ $trans['lang'] }}"
              href="{{ $trans['url'] }}" />
    @endforeach
    @endif

    @include('front.partials.og-meta', [
        'ogImage' => $article['title_image']['share'],
        'ogTitle' => $article['title'],
        'ogDescription' => $article['description'],
    ])
@endsection



@section('content')
    @include('front.partials.categories-nav')
    <div class="max-w-4xl mx-auto">
        <div class="mt-0 sm:mt-12 relative">
            <img src="{{ $article['title_image']['web'] }}" class="w-full"
                 alt="">
            <div class="bg-grey-700 sm:bg-tinted text-white sm:absolute bottom-0 w-full py-4 sm:py-2 px-4">
                <h1 class="type-h1 my-4">{{ $article['title'] }}</h1>
            </div>
        </div>
        <div class="flex justify-between items-center px-4 border-b-2 border-grey-300 mb-10">
            <p class="type-b5 my-2">by {{ $article['author_name'] }} on {{ $article['publish_date'] }}</p>
            <div class="flex">
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($article['title'] . ' ' . Request::url()) }}">
                    @include('svg.social-icons.twitter', ['classes' => 'fill-current text-red-700 hover:text-red-500 h-6 mr-4'])
                </a>

                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}">
                    @include('svg.social-icons.facebook', ['classes' => 'fill-current text-red-700 hover:text-red-500 h-6'])
                </a>

            </div>

        </div>

        <div class="max-w-2xl mx-auto px-4 article-content pb-8">{!! $article['body'] !!}</div>

        <div class="h-1 bg-grey-300 max-w-4xl mx-auto"></div>

        <div class="max-w-2xl mx-auto mt-8 px-4">
            <p class="type-b4 text-grey-500">{{ trans('blog-show.tags.title') }}:</p>
            <div class="">
                @foreach($article['tags'] as $tag)
                    <a class="inline-block uppercase text-grey-500 hover:text-red-500 type-b6 mr-6 mb-6 whitespace-no-wrap" href="/tags/{{ $tag['slug'] }}">{{ $tag['tag_name'] }}</a>
                @endforeach
            </div>
        </div>

        <div class="max-w-4xl mx-auto my-12">
            <p class="mx-2 type-h2 pl-4 leading-none border-l-4 border-red-700 uppercase mb-4">{{ trans('blog-show.related.title') }}</p>
            <div class="whitespace-no-wrap  overflow-auto px-4 md:flex justify-around">
                @foreach($article['related_posts'] as $post)
                    @include('front.blog.related-article-card', ['post' => $post])
                @endforeach
            </div>
        </div>


        @if(!$in_requested_lang)
            <foreign-language-alert lang="{{ app()->getLocale() }}"></foreign-language-alert>
        @endif

        <div class="max-w-4xl mx-auto mt-20">
            <p class="mx-2 type-h2 pl-4 leading-none border-l-4 border-red-700 uppercase mb-4">{{ trans('blog-show.comments.title') }}</p>
            <page-comments :translation-id="{{ $article['id'] }}" lang="{{ app()->getLocale() }}"></page-comments>
        </div>

    </div>



@endsection

@section('bodyscripts')
    @include('front.partials.article-rich-snippet')
@endsection
