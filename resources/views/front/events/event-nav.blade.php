<div class="sticky sticky-nav top-16 bg-red-700 text-white pl-6 overflow-hidden w-screen py-2 z-10">
    <div class="flex justify-start lg:justify-center overflow-x-auto">
        @if($event['has_activities'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" data-jump-target="races" href="#races">{{ $event['race_menu_name'] }}</a>
        @endif
        @if($event['has_schedule'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" data-jump-target="schedule" href="#schedule">{{ trans('navbar.event_nav.schedule') }}</a>
        @endif
        @if($event['has_fees'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" data-jump-target="fees" href="#fees">{{ trans('navbar.event_nav.fees') }}</a>
        @endif
        @if($event['has_travel'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" data-jump-target="travel" href="#travel">{{ trans('navbar.event_nav.travel') }}</a>
        @endif
        @if($event['has_accommodation'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" data-jump-target="accommodation" href="#accommodation">{{ trans('navbar.event_nav.accommodation') }}</a>
        @endif
        @if($event['has_sponsors'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" data-jump-target="sponsors" href="#sponsors">{{ trans('navbar.event_nav.sponsors') }}</a>
        @endif
        @if($event['has_galleries'])
            <a class="type-h2 uppercase pr-6 whitespace-no-wrap" data-jump-target="photos" href="#photos">{{ trans('navbar.event_nav.photos') }}</a>
        @endif
        @if($event['has_videos'])
            <a class="type-h2 uppercase pr-6 whitespace-no-wrap" data-jump-target="videos" href="#videos">{{ trans('navbar.event_nav.videos') }}</a>
        @endif
    </div>
</div>
