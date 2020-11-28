@if(count($people))
    <div class="py-20 px-6">
        <div class="max-w-5xl mx-auto">
            <p class="type-h2 uppercase mb-6">{{ trans('campaigns.friends_heading') }}</p>
            <div class="grid gap-10 md:grid-cols-3 place-content-center">
                @foreach($people as $person)
                    <div class="max-w-sm mx-auto shadow-small relative bg-grey-300">
                        <a href="{{ $person['slug'] }}">
                            <img src="{{ $person['profile_pic'] }}"
                                 alt="{{ $person['name'] }}"
                                 class="border-b-4 border-red-700">
                        </a>
                        <p class="px-3 w-full truncate type-h2 uppercase">{{ $person['name'] }}</p>
                        <div class="text-right p-2">
                            <a class="type-b2 uppercase hover:text-red-500"
                               href="{{ $person['slug'] }}">See Profile &gt;</a>
                        </div>
                        <p class="bg-red-700 px-2 py-1 top-0 right-0 m-3 text-white absolute type-b2 uppercase">{{ $person['type'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
