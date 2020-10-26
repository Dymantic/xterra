<div class="video-banner min-h-banner-tall md:min-h-banner pb-20 relative flex flex-col justify-end items-center" style="background-image: url({{ $campaign['banner_image']['full'] }}); background-size: cover; background-position: center;">
    @if($campaign['banner_video'])
        <div class="absolute inset-0" style="z-index: -1">
            <video src="{{ $campaign['banner_video'] }}" class="hidden banner-video w-full h-full object-cover" muted autoplay loop playsinline></video>
        </div>

        @if($campaign['promo_video_id'])
            <div x-data="{ open: false}" x-cloak
                 @keydown.window.escape="window.pausePromoVideo(); open = false">
                <button @click="open = true; window.playPromoVideo()"
                        class="px-8 py-2 uppercase rounded-lg bg-white text-grey-700 type-h3 shadow-lg mt-12 focus:outline-none">
                    {{ trans('campaigns.watch_video') }}
                </button>
                <div x-show="open" class="fixed flex justify-center items-center z-50 inset-0 bg-tinted-dark">
                    <div class="w-full max-w-5xl mx-auto">
                        <div style="padding-bottom: 56.25%" class="w-full relative">
                            <iframe id="home-promo-video" class="absolute inset-0 w-full h-full"
                                    src="https://www.youtube.com/embed/{{ $campaign['promo_video_id'] }}?enablejsapi=1"
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
    @endif
</div>
