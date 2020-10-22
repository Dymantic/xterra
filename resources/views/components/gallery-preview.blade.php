<div class="max-w-3xl mx-auto mb-6">
    <p class="font-bold px-6">
        <a href="{{ $slug }}">{{ $title }}</a>
    </p>
    <div class="flex flex-wrap justify-center">
        @foreach($firstImages() as $image)
            <div class="w-24 md:w-42 h-24 md:h-42 m-1">
                <img src="{{ $image['thumb'] }}" class="w-full h-full object-cover" alt="">
            </div>
        @endforeach
        @if($hasExtra())
                <div class="w-24 md:w-42 h-24 md:h-42 m-2 flex items-center justify-center bg-gray-100">
                    <p class="text-gray-600 type-h2 pb-1 mr-1">+ {{ $extraCount() }}</p>
                    @include('svg.icons.camera', ['classes' => 'h-6 text-gray-600'])
                </div>
        @endif
    </div>
    <div class="flex justify-center mt-8">
        <a class="blue-btn" href="{{ $slug }}">View Gallery</a>
    </div>
</div>
