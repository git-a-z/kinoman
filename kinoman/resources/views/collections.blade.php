@extends('layouts.main')

@section('title')
    @parent Коллекции
@endsection

@section('pageName')
    @parent Коллекции
@endsection

@section('content')
    <main class="content">
        <ul>
            <li class="main_catalog">
                @forelse($data as $key => $collection)
                    <h2 class="h2-km">{{$key}}</h2>
                    <div class="grid main_catalog_section">
                        @forelse($collection as $item)
                            @include('blocks.card', ['item' => $item])
                        @empty
                            <p>Кина не будет</p>
                        @endforelse
                    </div>
                    <div class="collection-interval"></div>
                @empty
                    <p>Кина не будет</p>
                @endforelse
            </li>
        </ul>
    </main>
@endsection
