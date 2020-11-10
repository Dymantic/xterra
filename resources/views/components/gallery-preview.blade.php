<div class="max-w-3xl mx-auto mb-12">
    <p class="font-bold px-8">
        <a href="{{ $slug }}">{{ $title }}</a>
    </p>
    <div class="grid grid-cols-3 md:grid-cols-4 gap-1 place-content-center">
        @foreach($firstImages() as $image)
            <div class="relative" style="padding-bottom: 100%;">
                <a href="{{ $slug }}">
                    <img src="{{ $image['thumb'] }}" class="w-full h-full object-cover inset-0 absolute" alt="">
                </a>
            </div>
        @endforeach
        @if($hasExtra())
                <div class="flex items-center justify-center bg-gray-100" style="">
                    <a href="{{ $slug }}" class="flex justify-center items-center">
                        <p class="text-gray-600 type-h2 pb-1 mr-1">+ {{ $extraCount() }}</p>
                        @include('svg.icons.camera', ['classes' => 'h-6 text-gray-600'])
                    </a>
                </div>
        @endif
    </div>
    <div class="flex justify-center mt-8">
        <a class="blue-btn" href="{{ $slug }}">{{ trans('events.view_gallery') }}</a>
    </div>
</div>
