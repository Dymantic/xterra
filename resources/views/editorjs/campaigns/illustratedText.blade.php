<div class="flex flex-col md:flex-row justify-between items-center my-6">
    <div class="w-1/2 {{ $align === 'right' ? 'order-1 mr-6' : 'order-2 ml-6' }}" >
        <p class="text-xl font-bold">{{ $header }}</p>
        <p class="mt-3">{{ $text }}</p>
    </div>
    <div class="w-1/2 {{ $align === 'right' ? 'order-2 ml-6' : 'order-1 mr-6' }}">
        <img src="{{ $image_src }}" alt="">
    </div>
</div>
