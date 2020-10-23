<div id="sponsors" class="py-20 px-8">
    <div class="max-w-4xl mx-auto">
        <p class="type-h2 mb-6 uppercase">Event Sponsors</p>
        <div class="flex flex-wrap justify-center">
            @foreach($event['sponsors'] as $sponsor)
                <div class="w-32 h-32 m-4">
                    <a href="{{ $sponsor['link'] }}" target="_blank">
                        <img class="w-full h-full object-contain" src="{{ $sponsor['logo']['thumb'] }}" alt="{{ $sponsor['name'] }}">
                    </a>

{{--                    <div>--}}
{{--                        <div class="h-40 w-40 mx-auto">--}}
{{--                            <img class="w-full h-full object-contain" src="{{ $sponsor['logo']['thumb'] }}" alt="{{ $sponsor['name'] }}">--}}
{{--                        </div>--}}

{{--                        <p class="my-2 type-b2">{{ $sponsor['name'] }}</p>--}}

{{--                        <p class="text-sm">{{ $sponsor['description'] }}</p>--}}
{{--                    </div>--}}


{{--                    <div class="flex justify-end mt-6">--}}
{{--                        <a target="_blank" href="{{ $sponsor['link'] }}" class="type-b2 text-blue-700 uppercase">Visit Sponsor &gt;</a>--}}
{{--                    </div>--}}
                </div>
            @endforeach
        </div>
    </div>
</div>
