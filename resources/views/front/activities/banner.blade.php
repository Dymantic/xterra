<div class="event-banner min-h-banner-tall md:min-h-banner bg-cover flex flex-col justify-center sm:pl-3 md:pl-32 sm:pr-3">

    <img src="{{ $activity['title_image']['mobile'] }}" alt="{{ $activity['name'] }}" class="block sm:hidden" style="width: 100vw; height: 100vw; object-fit: cover;">

    <div class="max-w-xl w-full mx-auto lg:mx-0 bg-tinted-dark p-4 sm:rounded leading-tight">
        <div class="hidden sm:flex justify-between items-center my-2 py-2 border-b-2 border-red-500">
            <p class="text-white type-h2">{{ $activity['distance'] }}</p>
            @include('svg.event-categories.' . $activity['category'], ['classes' => 'h-8 text-white mr-4 md:ml-4 md:mr-0'])
        </div>
        <p class="body-font font-bold text-2xl sm:text-6xl uppercase text-white my-3 sm:my-4">{{ $activity['name'] }}</p>
        <div class="flex items-center mb-2 sm:mb-0">
            @include('svg.icons.location', ['classes' => 'h-5 sm:h-6 text-red-500 mr-2'])
            <p class="font-heading font-medium text-lg sm:text-4xl uppercase sm:capitalize text-white">{{ $activity['venue_name'] ?: $activity['location'] }}</p>
        </div>
        <div class="flex items-center">
            @include('svg.icons.calendar', ['classes' => 'h-5 sm:h-6 text-red-500 mr-2'])
            <p class="font-heading font-medium text-lg sm:text-4xl uppercase sm:capitalize text-white">{{ $activity['date'] }}</p>
        </div>
        <div class="mt-6 mb-5 sm:mb-2">
            @if($activity['registration_link'])
                <a href="{{ $activity['registration_link'] }}" target="_blank" class="red-btn">{{ trans('activities.register_now') }} &gt;</a>
            @endif
        </div>
    </div>
</div>
