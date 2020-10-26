<div class="sticky sticky-nav top-16 bg-red-700 text-white pl-6 overflow-hidden w-screen py-2 z-10">
    <div class="flex justify-start lg:justify-center overflow-x-auto">
        @if($activity['has_courses'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" href="#courses">{{ trans('navbar.race_nav.courses') }}</a>
        @endif
        @if($activity['has_schedule'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" href="#schedule">{{ trans('navbar.race_nav.schedule') }}</a>
        @endif
        @if($activity['has_prizes'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" href="#prizes">{{ trans('navbar.race_nav.prizes') }}</a>
        @endif
        @if($activity['has_fees'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" href="#fees">{{ trans('navbar.race_nav.fees') }}</a>
        @endif
        @if($activity['has_rules_and_info'])
            <a class="type-h2 uppercase pr-6 whitespace-no-wrap" href="#rules">{{ trans('navbar.race_nav.rules') }}</a>
        @endif
    </div>
</div>
