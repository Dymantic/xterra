<div class="video-banner relative min-h-banner">
    <div class="absolute top-0 bottom-0 left-0 right-0" style="z-index: -1;">
        <picture class="">
            <source srcset="{{ $page['banner_lg'] }}" media="(min-width: 601px)">
            <source srcset="{{ $page['banner_sm'] }}" media="(max-width: 600px)">
            <img class="object-cover h-full w-full block" src="{{ $page['banner_lg'] }}" alt="banner image">
        </picture>
    </div>

    @if($page['banner_video'])
        <div x-data="{show: false}" class="absolute inset-0" style="z-index: -1">
            <video @canplaythrough="show = true" x-show="show" src="{{ $page['banner_video'] }}"
                   class="banner-video w-full h-full object-cover" muted autoplay loop playsinline></video>
        </div>
    @endif

    <div class="flex flex-col justify-center items-center py-32 px-6">
        <p class="type-banner text-white uppercase text-center">{!! $page['banner_heading'] !!}</p>

        <p class="type-h2 text-white mt-12 text-center max-w-2xl">{!! $page['banner_subheading'] !!}</p>

        @if($page['promo_video_id'])
            <div x-data="{ open: false, ready: promoVideoIsReady}" x-cloak
                 @keydown.window.escape="window.pausePromoVideo(); open = false">
                <button @click="open = true; window.playPromoVideo()"
                        class="white-btn mt-12 focus:outline-none">
                    {{ trans('homepage.watch_video') }}
                </button>
                <div x-show="open" class="fixed flex justify-center items-center z-50 inset-0 bg-tinted-dark">
                    <div class="w-full max-w-5xl mx-auto">
                        <div style="padding-bottom: 56.25%" class="w-full relative">
                            <iframe id="home-promo-video" class="absolute inset-0 w-full h-full"
                                    src="https://www.youtube.com/embed/{{ $page['promo_video_id'] }}?enablejsapi=1"
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
        @endif
    </div>
</div>
