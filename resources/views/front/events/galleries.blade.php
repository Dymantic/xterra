@if($event['has_galleries'])
<div class="pb-20" id="photos">
    <div class="max-w-4xl mx-auto">
        <p class="type-h2 uppercase mb-6 px-8 lg:px-0">{{ trans('events.galleries') }}</p>
        @foreach($event['galleries'] as $gallery)
            <x-gallery-preview :gallery="$gallery"></x-gallery-preview>
        @endforeach
    </div>
</div>
@endif
