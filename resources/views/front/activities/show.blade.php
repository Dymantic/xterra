@extends('front.base')

@section('content')
    @include('front.activities.banner')
    @include('front.activities.activity-nav')
    @include('front.activities.courses')
    @include('front.activities.schedule')
    @include('front.activities.prizes')
    @include('front.activities.fees')

    <div class="py-20 px-8">
        <div class="max-w-5xl mx-auto">
            <p class="type-h2 uppercase mb-6">Rules And Info</p>

            <div class="max-w-3xl mx-auto">
                {!! $activity['race_rules_html'] !!}
            </div>

            <div class="max-w-3xl mx-auto">
                {!! $activity['race_info_html'] !!}
            </div>

            <div class="mt-12 flex flex-col items-center justify-center">
                @if($activity['race_rules_document'])
                    <a download="race_rules" href="{{ $activity['race_rules_document'] }}" class="type-h4 uppercase">Download Race Rules (English)</a>
                @endif

                @if($activity['zh_race_rules_document'])
                    <a download="race_rules_zh" href="{{ $activity['zh_race_rules_document'] }}" class="type-h4 uppercase">Download Race Rules (Chinese)</a>
                @endif
            </div>
        </div>
    </div>







@endsection
