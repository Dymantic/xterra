<div class="flex flex-wrap justify-center">
@foreach($event['sponsors'] as $sponsor)
    <div class="w-16 md:w-40 h-16 md:h-40 m-4 md:m-8">
        <a href="{{ $sponsor['link'] }}" target="_blank">
            <img class="w-full h-full object-contain" src="{{ $sponsor['logo']['thumb'] }}" alt="{{ $sponsor['name'] }}">
        </a>
    </div>
@endforeach
</div>
