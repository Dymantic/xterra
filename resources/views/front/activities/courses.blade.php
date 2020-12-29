@if($activity['has_courses'])
<div class="pb-20 px-8" id="courses">
    <div class="max-w-4xl mx-auto">
        <p class="type-h2 uppercase mb-6">{{ trans('activities.courses') }}</p>
        @foreach($activity['courses'] as $course)
            <div class="max-w-3xl mx-auto my-10">
                <div class="flex">
                    <p class="font-bold">{{ $course['name'] }}</p>
                    @if($course['gpx_file'])
                        <a class="ml-3 text-blue-700 hover:underline" download="{{ str_replace(" ", "_", $course['name']) }}_gpx-file.gpx" href="{{ $course['gpx_file'] }}">({{ trans('activities.download_gpx') }})</a>
                    @endif
                </div>

                <p class="my-4">{{ $course['description'] }}</p>

                <div x-data="{showFullImage: false, src: null}" @keydown.escape.window="showFullImage = false">
                    @if(count($course['gallery']) > 1)
                        <div data-flickity='{"imagesLoaded": "true", "alignCells": "left", "contain": "true", "arrowShape":"M33.79 49.99l38.08 38.09h-5.66L28.13 49.99l38.08-38.08h5.66L33.79 49.99z"}'>
                            @foreach($course['gallery'] as $image)
                                <div class="course-gallery-slide max-w-3xl w-full relative border border-gray-300">
                                    <img src="{{ $image['web'] }}" alt="Picture number {{ $loop->index + 1 }} of {{ $course['name'] }}" class="w-full h-full object-scale-down">
                                    <button @click="src = '{{ $image['original'] }}'; showFullImage = true" class="absolute top-0 right-0 h-8 w-8 rounded-full bg-tinted-dark flex justify-center items-center mt-8 mr-6 focus:outline-none">
                                        <svg class="fill-current h-4 hover:text-red-700 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M6.987 10.987l-2.931 3.031L2 11.589V18h6.387l-2.43-2.081 3.03-2.932-2-2zM11.613 2l2.43 2.081-3.03 2.932 2 2 2.931-3.031L18 8.411V2h-6.387z"/></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(count($course['gallery']) === 1)
                            <div class="flex justify-center max-w-3xl w-full">
                                <div class="relative">
                                    <img src="{{ $course['gallery'][0]['web'] }}" class="mx-auto" alt="{{ $course['name'] }}">
                                    <button @click="src = '{{ $course['gallery'][0]['original'] }}'; showFullImage = true" class="focus:outline-none absolute top-0 right-0 h-8 w-8 rounded-full bg-tinted-dark flex justify-center items-center mt-3 mr-3">
                                        <svg class="fill-current h-4 hover:text-red-700 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M6.987 10.987l-2.931 3.031L2 11.589V18h6.387l-2.43-2.081 3.03-2.932-2-2zM11.613 2l2.43 2.081-3.03 2.932 2 2 2.931-3.031L18 8.411V2h-6.387z"/></svg>
                                    </button>
                                </div>

                            </div>

                    @endif

                        <div class="fixed z-50 inset-0 bg-grey-700" x-show="showFullImage">
                            <button @click="showFullImage = false" class="focus:outline-none type-h0 text-white hover:text-red-700 absolute top-0 right-0 m-2 leading-none">&times;</button>
                            <img :src="src" class="w-full h-full object-scale-down" alt="">
                        </div>
                </div>

            </div>
        @endforeach


            <div class="mt-12 flex flex-col md:flex-row gap-10 items-center justify-center">
                @if($activity['athletes_guide'])
                <a download="athlete_guide" href="{{ $activity['athletes_guide'] }}" class="blue-btn">{{ trans('activities.athletes_guide_en') }}</a>
                @endif

                    @if($activity['zh_athletes_guide'])
                        <a download="athlete_guide" href="{{ $activity['zh_athletes_guide'] }}" class="blue-btn">{{ trans('activities.athletes_guide_zh') }}</a>
                    @endif
            </div>
    </div>
</div>
@endif
