<main class="content">
    <ul>
        <li class="main_catalog">
            @forelse($data as $key => $collection)
                <a href="{{route($route, $collection[0]->collection_id)}}" class="catalog_link">
                    <h2 class="h2-km catalog_link">{{$key}}</h2>
                </a>
                @include('blocks.cards', ['data' => $collection])
                <div class="collection-interval"></div>
            @empty
            @endforelse
        </li>
    </ul>
</main>
