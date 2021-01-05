@extends('front.base', ['all_scripts' => false,])

@section('head')
    <script src="https://cdn.jsdelivr.net/npm/meilisearch@0.17.0/dist/bundles/meilisearch.umd.min.js"></script>
@endsection

@section('content')

    <div x-data="meilisearch()"
         x-init="() => getIndexes()" class="px-6">
        <div class="pt-20 px-6 flex flex-col justify-center items-center">

            <h1 class="type-h1 uppercase text-center mb-8">{{ trans('search.search_website') }}</h1>

            <input type="text"
                   x-model="query"
                   @input="search"
                   placeholder="{{ trans('search.search_xterra') }}"
                   class="border p-2 w-full max-w-md">
        </div>

        <div style="min-height: 40vh;">
            <template x-for="section in sections" :key="section.name">
                <div class="max-w-3xl mx-auto my-12" x-show="results[section.name].length && query.length > 1">
                    <span class="inline-block px-2 py-1 my-2 bg-red-700 text-white text-xs uppercase" x-text="section.label"></span>
                    <template x-for="hit in results[section.name]"
                              :key="hit.id">
                        <div class="mb-3 pb-3 border-b border-gray-400">
                            <p
                                class="type-h3">
                                <a :href="hit.link" x-text="hit.title" class="hover:text-red-700"></a>
                            </p>
                            <p x-text="hit.description"
                               class="type-b1"></p>
                        </div>

                    </template>
                </div>
            </template>
        </div>




    </div>



    <script>
        function meilisearch() {
            return {
                client: new MeiliSearch({host: "{{ config('meilisearch.host') }}", apiKey: "{{ config('meilisearch.public_key') }}"}),
                query: '{{ $query }}',
                indexes: [],
                lang: "{{ app()->getLocale() }}",
                sections: [
                    {name: 'events', label: 'events'},
                    {name: 'campaigns', label: 'initiatives'},
                    {name: 'translations', label: 'blog'},
                    {name: 'coaches', label: 'coaches'},
                    {name: 'ambassadors', label: 'ambassadors'},
                ],
                results: {
                    translations: [],
                    events: [],
                    campaigns: [],
                    coaches: [],
                    ambassadors: [],
                },
                search() {
                    if(!this.indexes.length) {
                        return;
                    }
                    this.indexes.forEach(ind => {

                        this.client.getIndex(ind.uid)
                            .then(search_index => {
                                search_index.search(this.query)
                                            .then(({hits}) => this.setHits(ind.uid, hits))
                                            .catch(() => {});
                            })
                            .catch(() => {});
                    })
                },
                setHits(index, hits) {
                    this.results[index] = hits
                        .filter(h => h.result.languages.includes(this.lang))
                        .map(hit => ({
                        id: `index_${hit.id}`,
                        title: hit.result.title[this.lang],
                        description: hit.result.description[this.lang],
                        link: hit.canonical_url,
                    }))

                },
                getIndexes() {
                    this.client.listIndexes()
                        .then(indexes => {
                            this.indexes = indexes;
                            this.results = indexes.reduce((resultList, ind) => {
                                resultList[ind.uid] = [];
                                return resultList;
                            }, {})
                        })
                    .then(() => this.search());
                }
            };
        }
    </script>
@endsection
