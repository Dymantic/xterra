@extends('front.base', ['all_scripts' => false])

@section('title'){{ trans('people.meta.title') }}@endsection

@section('head')
    @include('front.partials.og-meta', [
        'ogTitle' => trans('people.meta.title'),
        'ogDescription' => trans('people.meta.description')
    ])
@endsection

@section('content')
    <div class="py-20 px-8"
         x-data="people()">
        <p class="max-w-2xl mx-auto text-center type-h4">{{ trans('people.index_intro') }}</p>

        <div class="my-12 flex justify-center">
            <button class="type-b4 mx-8 focus:outline-none"
                    @click="setCategory('all')"
                    :class="{'underline': category === 'all'}">{{ trans('people.all') }}
            </button>
            <button class="type-b4 mx-8 focus:outline-none"
                    @click="setCategory('coach')"
                    :class="{'underline': category === 'coach'}">{{ trans('people.coaches') }}
            </button>
            <button class="type-b4 mx-8 focus:outline-none"
                    @click="setCategory('ambassador')"
                    :class="{'underline': category === 'ambassador'}">{{ trans('people.ambassadors') }}
            </button>
        </div>

        <div class="max-w-5xl mx-auto py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            @foreach($people as $person)
                <div class="max-w-sm mx-auto shadow-small relative bg-grey-300"
                     x-show="category === 'all' || category === '{{ $person['category'] }}'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-50"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-50">
                    <a href="{{ $person['slug'] }}">
                        <img src="{{ $person['profile_pic'] }}"
                             alt="{{ $person['name'] }}" class="border-b-4 border-red-700">
                    </a>
                    <p class="px-3 w-full truncate type-h2 uppercase">{{ $person['name'] }}</p>
                    <div class="text-right p-2">
                        <a class="type-b2 uppercase hover:text-red-500"
                           href="{{ $person['slug'] }}">{{ trans('people.view_profile') }}</a>
                    </div>
                    <p class="bg-red-700 px-2 py-1 top-0 right-0 m-3 text-white absolute type-b2 uppercase">{{ $person['type'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function people() {
            return {
                category: 'all',
                setCategory(category) {
                    this.category = '';
                    window.setTimeout(() => this.category = category, 300);
                }
            }
        }
    </script>

@endsection
