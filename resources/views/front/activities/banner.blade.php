<div class="min-h-banner-tall md:min-h-banner bg-cover flex flex-col justify-center pl-3 md:pl-32 pr-3" style="background-image: url({{ $activity['title_image']['banner'] }})">
    <div class="max-w-xl w-full mx-auto lg:mx-0 bg-tinted-dark p-4 rounded leading-tight">
        <div class="flex justify-between items-center my-2 py-2 border-b-2 border-red-500">
            <p class="text-white type-h2">{{ $activity['distance'] }}</p>
            @include('svg.event-categories.' . $activity['category'], ['classes' => 'h-8 text-white mr-4 md:ml-4 md:mr-0'])
        </div>
        <p class="type-h0 uppercase text-white my-4">{{ $activity['name'] }}</p>
        <div class="flex items-center">
            @include('svg.icons.location', ['classes' => 'h-6 text-red-500 mr-2'])
            <p class="type-h1 text-white">{{ $activity['venue_name'] ?: $activity['location'] }}</p>
        </div>
        <div class="flex items-center">
            @include('svg.icons.calendar', ['classes' => 'h-6 text-red-500 mr-2'])
            <p class="type-h1 text-white">{{ $activity['date'] }}</p>
        </div>
        <div class="text-right mt-4">
            @if($activity['registration_link'])
            <a href="{{ $activity['registration_link'] }}" target="_blank" class="type-b2 text-white hover:text-red-700 uppercase">Register Now &gt;</a>
                @endif
        </div>
    </div>
</div>
