<div class="sticky sticky-nav top-16 bg-red-700 text-white pl-6 overflow-hidden w-screen py-2 z-10">
    <div class="flex justify-start lg:justify-center overflow-x-auto">
        @if($activity['has_courses'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" href="#courses">Courses</a>
        @endif
        @if($activity['has_schedule'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" href="#schedule">Schedule</a>
        @endif
        @if($activity['has_prizes'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" href="#prizes">Prizes</a>
        @endif
        @if($activity['has_fees'])
            <a class="type-h2 uppercase mr-6 whitespace-no-wrap" href="#fees">Fees</a>
        @endif
        @if($activity['has_rules_and_info'])
            <a class="type-h2 uppercase pr-6 whitespace-no-wrap" href="#rules">Rules & Info</a>
        @endif
    </div>
</div>
