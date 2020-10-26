@if($campaign)
<div class="py-20 px-8">
    <div class="max-w-4xl mx-auto flex flex-col md:flex-row justify-between">
        <div class="fw-full md:w-1/2 order-2 md:order-1 mt-8 md:mt-0">
            <img src="{{ $campaign['image'] }}" alt="{{ $campaign['title'] }}">
        </div>
        <div class="fw-full md:w-1/2  order-1 md:order-2 px-8 flex flex-col justify-center">
            <p class="type-h0 text-center">
                <a href="{{ $campaign['full_slug'] }}" class="hover:text-red-700">{{ $campaign['title'] }}</a>
            </p>
            <p class="type-b1 mt-8">{{ $campaign['intro'] }}</p>

            <div class="mt-10 text-center">
                <a class="type-b2 uppercase hover:text-red-500" href="{{ $campaign['full_slug'] }}">{{ trans('homepage.view_initiative') }} &gt;</a>
            </div>
        </div>
    </div>
</div>
@endif
