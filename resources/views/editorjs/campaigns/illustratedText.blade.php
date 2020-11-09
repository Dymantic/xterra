<div class="flex flex-col md:flex-row justify-between items-start my-6 py-4 md:py-20">
    <div class="w-full md:w-1/2 {{ $align === 'right' ? 'md:order-1 mr-6' : 'md:order-2 md:ml-6' }}" >
        <p class="type-h1 font-bold">{!! $header !!}</p>
        <p class="mt-3">{!! $text !!}</p>
    </div>
    <div class="w-full md:w-1/2 mt-10 md:mt-0 {{ $align === 'right' ? 'md:order-2 md:ml-6' : 'md:order-1 md:mr-6' }}">
        <img src="{{ is_array($image_src) ? '' : $image_src }}" alt="">
    </div>
</div>
