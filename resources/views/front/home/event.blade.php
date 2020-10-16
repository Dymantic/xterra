@if($event)
    <div style="background-image: url({{ $event['banner_image']['banner'] }})" class="bg-cover min-h-banner flex flex-col justify-center items-center px-4 md:pl-32  md:items-start py-8">
        <div class="bg-tinted-dark rounded p-6 w-full max-w-lg">
            <div class="flex flex-col md:flex-row justify-between border-b-2 border-red-500">
                <p class="type-h2 uppercase text-white">Next Event</p>
                <div class="flex items-center my-2">
                    @foreach($event['categories'] as $icon)
                        @include('svg.event-categories.' . $icon, ['classes' => 'h-6 text-white mr-4 md:ml-4 md:mr-0'])
                    @endforeach
                </div>
            </div>
            <p class="type-h1 text-white mt-3">{{ $event['name'] }}</p>
            <div class="flex items-center">
                @include('svg.icons.location', ['classes' => 'h-6 text-red-500 mr-2'])
                <p class="type-h2 uppercase text-white">{{ $event['location'] }}</p>
            </div>
            <div class="flex items-center">
                @include('svg.icons.calendar', ['classes' => 'h-6 text-red-500 mr-2'])
                <p class="type-h2 uppercase text-white">{{ $event['dates'] }}</p>
            </div>
            <div class="text-right mt-2">
                <a class="text-white hover:text-red-500 uppercase text-sm" href="/">View Event &gt;</a>
            </div>
        </div>
    </div>
@endif
