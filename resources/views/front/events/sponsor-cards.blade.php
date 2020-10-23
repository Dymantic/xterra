<div class="">
    @foreach($event['sponsors'] as $sponsor)
        <div class="flex flex-col md:flex-row max-w-xl mx-auto shadow-small mb-8">
            <div class="w-20 md:w-40 mx-auto md:mx-0 my-4 md:my-0 flex-shrink-0">
                <a href="{{ $sponsor['link'] }}" target="_blank">
                    <img class="w-full h-full object-contain" src="{{ $sponsor['logo']['thumb'] }}"
                         alt="{{ $sponsor['name'] }}">
                </a>

            </div>
            <div class="p-3 flex flex-col justify-between flex-1">
                <div class="mb-2">
                    <p class="mb-2 type-b2">{{ $sponsor['name'] }}</p>
                    <p class="text-sm">{{ $sponsor['description'] }}</p>
                </div>

                <div class="flex justify-end">
                    <a target="_blank" href="{{ $sponsor['link'] }}" class="type-b2 text-blue-700 uppercase">Visit
                        Sponsor &gt;</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
