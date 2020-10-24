@if($activity['has_fees'])
<div class="py-20 px-8" id="fees">
    <div class="max-w-4xl mx-auto">
        <p class="type-h2 uppercase mb-6">Fees</p>
        <div class="max-w-3xl mx-auto">
            <x-table
                :headings="['Category', 'Fee']"
                :rows="$activity['fees']"
                :columns="['category', 'fee']">

            </x-table>
            <div class="mt-12 max-w-2xl mx-auto admin-edited">
                <div>{!! $activity['fees_notes'] !!}</div>
            </div>
        </div>
    </div>
</div>
@endif
