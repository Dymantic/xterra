@if($event['has_sponsors'])
<div id="sponsors" class="py-20 px-8">
    <div class="max-w-4xl mx-auto">
        <p class="type-h2 mb-6 uppercase">{{ trans('events.sponsors') }}</p>
    </div>
    <div class="max-w-5xl mx-auto">
        @if(count($event['sponsors']) > 6)
            @include('front.events.sponsor-logo-grid')
        @else
            @include('front.events.sponsor-cards')
        @endif
    </div>
</div>
@endif
