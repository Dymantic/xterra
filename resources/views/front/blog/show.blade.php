@extends('front.base')

@section('head')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
    @include('front.partials.categories-nav')
    <div class="max-w-4xl mx-auto">
        <div class="mt-0 sm:mt-12 relative">
            <img src="{{ $article['title_image']['web'] }}" class="w-full"
                 alt="">
            <div class="bg-grey-700 sm:bg-tinted text-white sm:absolute bottom-0 w-full py-4 sm:py-2 px-4">
                <p class="type-b4">{{ $article['publish_date'] }}</p>
                <h1 class="type-h1 my-4">{{ $article['title'] }}</h1>
            </div>
        </div>
        <div class="flex justify-between items-center px-4 border-b-2 border-grey-300 mb-16">
            <p class="type-b5 my-2">by {{ $article['author_name'] }}</p>
            <div class="flex">
            @include('svg.social-icons.twitter', ['classes' => 'fill-current text-red-500 h-6 mr-4'])
            @include('svg.social-icons.facebook', ['classes' => 'fill-current text-red-500 h-6'])
            </div>

        </div>

        <div class="max-w-2xl mx-auto px-4 article-content">{!! $article['body'] !!}</div>

        <div class="max-w-2xl mx-auto mt-16 px-4">
            <p class="type-b4 text-grey-500">Tags:</p>
            <div class="flex justify-around">
                @foreach($article['tags'] as $tag)
                    <a class="uppercase text-grey-500 hover:text-red-500 type-b6" href="/tags/{{ $tag['slug'] }}">{{ $tag['tag_name'] }}</a>
                @endforeach
            </div>
        </div>

        <div class="max-w-4xl mx-auto my-12">
            <p class="type-h2 pl-4 leading-none border-l-4 border-red-700 uppercase mb-4">Related Articles</p>
            <div class="article-simple-grid">
                @foreach($article['related_posts'] as $post)
                    @include('front.blog.post-index-card', ['post' => $post])
                @endforeach
            </div>
        </div>

        <div class="max-w-4xl mx-auto mt-20">
            <p class="type-h2 pl-4 leading-none border-l-4 border-red-700 uppercase mb-4">Comment</p>
            <page-comments :translation-id="{{ $article['id'] }}"></page-comments>
        </div>

    </div>




@endsection
