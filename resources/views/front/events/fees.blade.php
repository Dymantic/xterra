@if($event['has_fees'])
<div class="pb-20 px-8" id="fees">
    <div class="max-w-4xl mx-auto">
        <p class="type-h2 uppercase mb-6">{{ trans('events.fees') }}</p>
        <div class="max-w-3xl mx-auto">
            <x-table :headings="[trans('events.fees_category'), trans('events.fees_fee')]" :rows="$event['fees']" :columns="['category', 'fee']"></x-table>
        </div>
    </div>

</div>
@endif
