<div class="slideshow not-ready overflow-hidden bg-grey-700">
    <div class="relative slide-container">
        @foreach($slideshow as $slide)
            <div class="w-full h-full slideshow-slide relative">
                <img src="{{ $slide['banner'] }}" class="w-full h-full object-cover opacity-0" style="transition: 3s;"
                     alt="">
                <div class="absolute bg-tinted bottom-0 left-0 w-full  flex px-8 py-4">
                    <p class="w-full sm:w-2/5 leading-tight type-h1 text-white uppercase sm:mr-4 sm:pr-4 sm:border-r sm:border-white">
                        <a href="{{ localUrl('/blog/' . $slide['slug']) }}">
                            {{ $slide['title'] }}
                        </a>
                    </p>
                    <p class="hidden sm:block flex-1 type-b1 text-white">{{ $slide['intro'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="h-8 bg-grey-700"></div>
</div>
