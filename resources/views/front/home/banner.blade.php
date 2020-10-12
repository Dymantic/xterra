<div class="relative min-h-banner">
    <div class="absolute top-0 bottom-0 left-0 right-0" style="z-index: -1;">
        <picture class="" >
            <source srcset="{{ $page['banner_lg'] }}" media="(min-width: 601px)">
            <source srcset="{{ $page['banner_sm'] }}" media="(max-width: 600px)">
            <img class="object-cover h-full w-full block" src="{{ $page['banner_lg'] }}" alt="banner image">
        </picture>
    </div>

    <div class="flex flex-col justify-center items-center py-32 px-6">
        <p class="type-banner text-white uppercase text-center">We Play, <br> And We Protect</p>

        <p class="type-h2 text-white mt-12 text-center max-w-2xl">XTERRA Taiwan brings endurance racing and the environment together on this beautiful island.</p>

        <a href="" class="px-8 py-2 uppercase rounded-lg bg-white text-grey-700 type-h3 shadow-lg mt-12">Next event</a>
    </div>
</div>
