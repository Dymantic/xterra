<div class="py-20" id="media">
    <div class="max-w-5xl mx-auto">
        <p class="type-h2 uppercase mb-6">Image Galleries</p>
        @foreach($event['galleries'] as $gallery)
            <x-gallery-preview :gallery="$gallery"></x-gallery-preview>
        @endforeach
    </div>
</div>
