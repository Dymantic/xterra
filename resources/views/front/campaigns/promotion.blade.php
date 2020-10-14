<div class="py-20 px-8 bg-gray-100">
    <div class="max-w-5xl mx-auto">
        <p class="type-h2 uppercase mb-6">Initiative Collectable</p>
        <div class="flex flex-col md:flex-row">
            <div class="w-full md:w-1/2">
                <img src="{{ $promo['image'] }}" alt="{{ $promo['title'] }}">
            </div>
            <div class="w-full md:w-1/2 max-w-md mx-auto md:pl-8 mt-10 md:mt-0">
                <p class="type-h0 uppercase text-center">{{ $promo['title'] }}</p>
                <p class="type-b1 mt-8 text-center">{{ $promo['writeup'] }}</p>
            </div>
        </div>
        <div class="text-center mt-20">
            <a class="px-8 py-2 uppercase rounded bg-blue-700 text-white type-h3 shadow-lg" href="{{ $promo['link'] }}">{{ $promo['button_text'] }}</a>
        </div>
    </div>
</div>
