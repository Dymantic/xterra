<div class="min-h-banner-tall md:min-h-banner flex flex-col justify-center pl-3 md:pl-32 pr-3" style="background-image: url({{ $activity['title_image']['banner'] }})">
    <div class="max-w-xl w-full mx-auto lg:mx-0 bg-tinted-dark p-4 rounded">
        <div class="flex justify-between items-center my-2 py-2 border-b-2 border-red-500">
            @include('svg.event-categories.' . $activity['category'], ['classes' => 'h-8 text-white mr-4 md:ml-4 md:mr-0'])
            <p class="text-white type-h2">{{ $activity['distance'] }}</p>
        </div>
        <p class="type-banner uppercase text-white my-4">{{ $activity['name'] }}</p>
        <div class="flex items-center">
            @include('svg.icons.location', ['classes' => 'h-6 text-red-500 mr-2'])
            <p class="type-h2 uppercase text-white">{{ $activity['location'] }}</p>
        </div>
        <div class="flex items-center">
            @include('svg.icons.calendar', ['classes' => 'h-6 text-red-500 mr-2'])
            <p class="type-h2 uppercase text-white">{{ $activity['date'] }}</p>
        </div>
    </div>
</div>
