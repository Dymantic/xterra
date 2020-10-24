@if($event['has_activities'])
<div class="pb-20 px-8" id="races">
    <div class="max-w-4xl mx-auto">
        @if(count($event['races']))
            <p class="type-h2 uppercase mb-6">Races</p>
            @foreach($event['races'] as $race)
                @include('front.events.activity-card', ['activity' => $race, 'type' => 'race'])
            @endforeach
        @endif

        @if(count($event['activities']))
            <p class="type-h2 uppercase mb-6">Activities</p>
            @foreach($event['activities'] as $activity)
                @include('front.events.activity-card', ['activity' => $activity, 'type' => 'activity'])
            @endforeach
        @endif
    </div>
</div>
@endif
