<div class="relative min-h-banner-tall md:min-h-banner bg-cover flex flex-col justify-center pl-3 md:pl-32 pr-3" style="background-image: url({{ $event['banner_image']['banner'] }})">
    <div class="max-w-xl w-full mx-auto lg:mx-0 bg-tinted-dark p-4 rounded mt-8 md:mt-0">
        <div class="flex items-center justify-end my-2 py-2 border-b-2 border-red-500">
            @foreach($event['categories'] as $icon)
                @include('svg.event-categories.' . $icon, ['classes' => 'h-8 text-white mr-4 md:ml-4 md:mr-0'])
            @endforeach
        </div>
        <p class="type-banner uppercase text-white my-4">{{ $event['name'] }}</p>
        <div class="flex items-center">
            @include('svg.icons.location', ['classes' => 'h-6 text-red-500 mr-2'])
            <p class="type-h2 uppercase text-white">{{ $event['location'] }}</p>
        </div>
        <div class="flex items-center">
            @include('svg.icons.calendar', ['classes' => 'h-6 text-red-500 mr-2'])
            <p class="type-h2 uppercase text-white">{{ $event['dates'] }}</p>
        </div>
        <div class="text-right mt-4">
            <a href="{{ $event['registration_link'] }}" target="_blank" class="type-b2 text-white hover:text-red-700 uppercase">Register Now &gt;</a>
        </div>


    </div>
    @if($event['promo_video_id'])
        <div class="flex justify-end mt-10">
            <div x-data="{ open: false}" x-cloak
                 @keydown.window.escape="window.pausePromoVideo(); open = false">
                <button @click="open = true; window.playPromoVideo()"
                        class="md:absolute bg-tinted-dark text-white hover:text-red-700 w-16 h-16 rounded-lg flex justify-center items-center bottom-0 right-0  mr-4 md:mr-8 mb-8 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current h-10">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                    </svg>

                </button>
                <div x-show="open" class="fixed flex justify-center items-center z-50 inset-0 bg-tinted-dark">
                    <div class="w-full max-w-5xl mx-auto">
                        <div style="padding-bottom: 56.25%" class="w-full relative">
                            <iframe id="home-promo-video" class="absolute inset-0 w-full h-full"
                                    src="https://www.youtube.com/embed/{{ $event['promo_video_id'] }}?enablejsapi=1"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        </div>
                    </div>
                    <button class="absolute top-0 right-0 mr-4 type-h0 text-white hover:text-red-700"
                            @click="window.pausePromoVideo(); open = false">&times
                    </button>
                </div>
            </div>
        </div>

    @endif
</div>
