<div class="py-20 px-8">
    <div class="max-w-5xl mx-auto">
        @if(count($event['races']))
            <p class="type-h2 uppercase mb-6">Races</p>
            @foreach($event['races'] as $race)
                <div class="max-w-2xl mx-auto p-6 rounded shadow-lg mb-12">
                    <p class="uppercase type-h2 text-blue-700">{{ $race['name'] }}</p>
                    <p><span class="font-bold">Distance: </span>{{ $race['distance'] }}</p>
                    <p>{{ $race['intro'] }}</p>
                    <div class="text-right mt-4">
                        <a href="">View Race &gt;</a>
                    </div>
                </div>
            @endforeach
        @endif

        @if(count($event['activities']))
            <p class="type-h2 uppercase mb-6">Activities</p>
            @foreach($event['activities'] as $activity)
                <div class="max-w-2xl mx-auto p-6 rounded shadow-lg mb-12">
                    <p class="uppercase type-h2 text-blue-700">{{ $activity['name'] }}</p>
                    <p>{{ $activity['distance'] }}</p>
                    <p class="max-w-xl mt-4">{{ $activity['intro'] }}</p>
                    <div class="text-right mt-4">
                        <a href="">View Activity &gt;</a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
