<main class="content">
    <ul>
        <li class="main_catalog">
            @forelse($data as $key => $collection)
                <a href="{{route($route, $collection[0]->collection_id)}}" class="main_catalog_link">
                    <h2 class="h2-km">{{$key}}</h2>
                </a>
                @include('blocks.collection', ['collection' => $collection])
                <div class="collection-interval"></div>
            @empty
            @endforelse
        </li>
    </ul>
</main>
