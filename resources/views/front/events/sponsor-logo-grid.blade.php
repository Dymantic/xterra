<div class="flex flex-wrap justify-center">
@foreach($event['sponsors'] as $sponsor)
    <div class="w-16 md:w-24 h-16 md:h-24 m-8">
        <a href="{{ $sponsor['link'] }}" target="_blank">
            <img class="w-full h-full object-contain" src="{{ $sponsor['logo']['thumb'] }}" alt="{{ $sponsor['name'] }}">
        </a>
    </div>
@endforeach
</div>
