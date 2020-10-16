<div class="py-20 px-8" id="courses">
    <div class="max-w-5xl mx-auto">
        <p class="type-h2 uppercase mb-6">Courses</p>
        @foreach($activity['courses'] as $course)
            <div class="max-w-3xl mx-auto my-10">
                <div class="flex">
                    <p class="font-bold">{{ $course['name'] }}</p>
                    @if($course['gpx_file'])
                        <a class="ml-3 text-blue-700 hover:underline" download="{{ str_replace(" ", "_", $course['name']) }}_gpx-file" href="{{ $course['gpx_file'] }}">(Download GPX file)</a>
                    @endif
                </div>

                <p class="my-4">{{ $course['description'] }}</p>
                @if(count($course['gallery']))
                    <div data-flickity='{"imagesLoaded": "true", "alignCells": "left", "contain": "true"}'>
                        @foreach($course['gallery'] as $image)
                            <img src="{{ $image['web'] }}" alt="">
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach


            <div class="mt-12 flex flex-col md:flex-row gap-10 items-center justify-center">
                @if($activity['athletes_guide'])
                <a download="athlete_guide" href="{{ $activity['athletes_guide'] }}" class="blue-btn">Download Athletes Guide (English)</a>
                @endif

                    @if($activity['zh_athletes_guide'])
                        <a download="athlete_guide" href="{{ $activity['zh_athletes_guide'] }}" class="blue-btn">Download Athletes Guide (Chinese)</a>
                    @endif
            </div>
    </div>
</div>
