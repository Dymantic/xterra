<div class="py-20 px-8" id="media">
    <div class="max-w-5xl mx-auto">
        <p class="type-h2 uppercase mb-6">Image Galleries</p>
        @foreach($event['galleries'] as $gallery)
            <div class="max-w-3xl mx-auto mb-6">
                <p class="font-bold">{{ $gallery['title'] }}</p>
                <div class="flex flex-wrap">
                    @foreach($gallery['images'] as $image)
                        <div class="w-42 h-42 m-2">
                            <img src="{{ $image['thumb'] }}" class="w-full h-full object-cover" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
