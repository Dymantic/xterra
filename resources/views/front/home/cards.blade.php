<div class="py-20 px-8 max-w-screen overflow-hidden">
    <div class="max-w-4xl mx-auto">
        <p class="type-h2 mb-6 uppercase">{{ trans('homepage.cards_heading') }}</p>
    </div>
    <div class="max-w-5xl mx-auto md:px-8 text-black" data-flickity='{"cellAlign": "left", "contain": "true", "imagesLoaded": "true", "arrowShape": "M33.79 49.99l38.08 38.09h-5.66L28.13 49.99l38.08-38.08h5.66L33.79 49.99z"}'>
        @foreach($page['content_cards'] as $card)
            <div class="w-full md:w-3/10 mx-6">
                <div class="relative w-9/10 mx-auto shadow-lg bg-gray-200">
                    <div class="w-full border-b-2 border-red-700">
                        <img src="{{ $card['image'] }}" class="w-full h-full object-cover" alt="{{ $card['title'] }}">
                    </div>
                    <p class="type-h2 p-2 leading-tight h-20 overflow-hidden">
                        <a class="hover:text-red-500" href="{{ $card['link'] }}">{{ $card['title'] }}</a>
                    </p>
                    <p class="m-2 absolute top-0 right-0 text-white bg-red-500 px-2 py-1 type-b2">{{ $card['category'] }}</p>
                </div>
            </div>

        @endforeach
    </div>
</div>
