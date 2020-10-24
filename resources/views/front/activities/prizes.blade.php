@if($activity['has_prizes'])
<div class="py-20 px-8" id="prizes">
    <div class="max-w-4xl mx-auto">
        <p class="type-h2 uppercase mb-6">Prizes</p>

        <div class="max-w-3xl mx-auto">
            {!! $activity['prizes_html'] !!}
        </div>
    </div>
</div>
@endif
