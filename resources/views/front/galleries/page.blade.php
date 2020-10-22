@extends('front.base', ['all_scripts' => false, 'flickity' => true])

@section('content')
    <div class="py-20">
        <div class="max-w-3xl mx-auto px-8">
            <h1 class="type-h0 uppercase text-center">{{ $gallery['title'] }}</h1>
            <p class="my-6 text-center">{{ $gallery['description'] }}</p>
        </div>
    </div>
    <div>
        <div x-data="{flick: null, flickNav: null}" x-init="flick = new Flickity(document.querySelector('.gallery'), {cellAlign: 'left', lazyLoad: true, arrowShape: 'M33.79 49.99l38.08 38.09h-5.66L28.13 49.99l38.08-38.08h5.66L33.79 49.99z'}); flick = new Flickity(document.querySelector('.gallery-nav'), {contain: true, pageDots: false, asNavFor: '.gallery', arrowShape: 'M33.79 49.99l38.08 38.09h-5.66L28.13 49.99l38.08-38.08h5.66L33.79 49.99z'})" class="max-w-4xl mx-auto">
            <div class="gallery">
                @foreach($gallery['images'] as $image)
                    <div class="bg-black w-full">
                        @if($loop->first)
                            <img src="{{ $image['web'] }}" data-flickity-lazyload="{{ $image['web'] }}" alt="gallery image">
                        @else
                            <img src="" data-flickity-lazyload="{{ $image['web'] }}" alt="gallery image">
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="gallery-nav my-12">
                @foreach($gallery['images'] as $image)
                    <img src="{{ $image['thumb'] }}" class="w-24 h-24 object-cover" alt="gallery image">
                @endforeach
            </div>
        </div>
    </div>
@endsection
