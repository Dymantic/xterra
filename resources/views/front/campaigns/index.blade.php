@extends('front.base')

@section('content')
    <div class="py-20 px-8">
        <p class="max-w-2xl mx-auto text-center type-h4">{{ trans('campaigns.index_intro') }}</p>

        <div class="max-w-3xl mx-auto py-12">
            @foreach($campaigns as $campaign)
                <div class="flex flex-col md:flex-row shadow-small mb-12">
                    <div class="w-full md:w-64 flex-shrink-0">
                        <a href="{{ $campaign['full_slug'] }}">
                            <img src="{{ $campaign['image'] }}" alt="{{ $campaign['title'] }}" class="h-full w-full object-cover">
                        </a>
                    </div>
                    <div class="p-4 bg-gray-100">
                        <p class="type-h2 border-b border-red-700 uppercase">
                            <a href="{{ $campaign['full_slug'] }}" class="hover:text-red-700">
                                {{ $campaign['title'] }}
                            </a>
                        </p>
                        <p class="type-b1 my-6">{{ $campaign['intro'] }}</p>
                        <div class="text-right">
                            <a href="{{ $campaign['full_slug'] }}" class="type-b2 hover:text-red-700">{{ trans('campaigns.see_initiative') }} &gt;</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
