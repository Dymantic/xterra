<div class="video-banner relative min-h-banner">
    <div class="absolute top-0 bottom-0 left-0 right-0" style="z-index: -1;">
        <picture class="" >
            <source srcset="{{ $page['banner_lg'] }}" media="(min-width: 601px)">
            <source srcset="{{ $page['banner_sm'] }}" media="(max-width: 600px)">
            <img class="object-cover h-full w-full block" src="{{ $page['banner_lg'] }}" alt="banner image">
        </picture>
    </div>

    @if($page['banner_video'])
        <div class="absolute inset-0" style="z-index: -1">
            <video src="{{ $page['banner_video'] }}" class="hidden banner-video w-full h-full object-cover" muted autoplay loop playsinline></video>
        </div>
    @endif

    <div class="flex flex-col justify-center items-center py-32 px-6">
        <p class="type-banner text-white uppercase text-center">{!! $page['banner_heading'] !!}</p>

        <p class="type-h2 text-white mt-12 text-center max-w-2xl">{!! $page['banner_subheading'] !!}</p>

        <a href="" class="px-8 py-2 uppercase rounded-lg bg-white text-grey-700 type-h3 shadow-lg mt-12">Next event</a>
    </div>
</div>
