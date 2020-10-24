@if($promo)
<div class="py-20">
    <div class="flex flex-col md:flex-row justify-start">
        <div class="w-full md:w-1/2">
            <img src="{{ $promo['image'] }}" alt="{{ $promo['title'] }}">
        </div>
        <div class="w-full md:w-1/2 flex flex-col justify-center px-8 max-w-lg">
            <p class="type-h0">{{ $promo['title'] }}</p>
            <p class="type-b1 my-4">{{ $promo['writeup'] }}</p>
            <div class="text-center mt-6">
                <a class="blue-btn" href="{{ $promo['link'] }}">{{ $promo['button_text'] }}</a>
            </div>
        </div>
    </div>
</div>
@endif
