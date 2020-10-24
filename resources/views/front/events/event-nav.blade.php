<div class="sticky sticky-nav top-16 bg-red-700 text-white pl-6 overflow-hidden w-screen py-2 z-10">
    <div class="flex justify-start lg:justify-center overflow-x-auto">
        @if($event['has_activities'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" href="#races">{{ $event['race_menu_name'] }}</a>
        @endif
        @if($event['has_schedule'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" href="#schedule">Schedule</a>
        @endif
        @if($event['has_fees'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" href="#fees">Fees</a>
        @endif
        @if($event['has_travel'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" href="#travel">Travel</a>
        @endif
        @if($event['has_accommodation'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" href="#accommodation">Accommodation</a>
        @endif
        @if($event['has_sponsors'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" href="#sponsors">Sponsors</a>
        @endif
        @if($event['has_galleries'])
            <a class="type-h2 uppercase pr-6 whitespace-no-wrap" href="#photos">Photos</a>
        @endif
        @if($event['has_videos'])
            <a class="type-h2 uppercase pr-6 whitespace-no-wrap" href="#videos">Videos</a>
        @endif
    </div>
</div>
