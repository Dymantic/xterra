<div class="py-20 px-8" id="fees">
    <div class="max-w-5xl mx-auto">
        <p class="type-h2 uppercase mb-6">Fees</p>
        <div class="max-w-3xl mx-auto">
            <x-table :headings="['Category', 'Fee']" :rows="$event['fees']" :columns="['category', 'fee']"></x-table>
        </div>
    </div>

</div>
