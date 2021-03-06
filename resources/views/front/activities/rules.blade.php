@if($activity['has_rules_and_info'])
<div class="pb-20 px-8" id="rules">
    <div class="max-w-4xl mx-auto">
        <p class="type-h2 uppercase mb-6">{{ trans('activities.rules') }}</p>

        <div class="max-w-3xl mx-auto">
            {!! $activity['race_rules_html'] !!}
        </div>

        <div class="max-w-3xl mx-auto">
            {!! $activity['race_info_html'] !!}
        </div>

        <div class="mt-12 flex flex-col md:flex-row gap-10 items-center justify-center">
            @if($activity['race_rules_document'])
                <a download="race_rules" href="{{ $activity['race_rules_document'] }}" class="blue-btn">{{ trans('activities.download_rules_en') }}</a>
            @endif

            @if($activity['zh_race_rules_document'])
                <a download="race_rules_zh" href="{{ $activity['zh_race_rules_document'] }}" class="blue-btn">{{ trans('activities.download_rules_en') }}</a>
            @endif
        </div>
    </div>

</div>
@endif
