@extends('layouts.main')

@section('title')
    @parent Каталог
@endsection

@section('pageName')
    @parent Каталог
@endsection

@section('content')
    <main class="content">
        <ul>
            <li class="main_catalog">
                <h2 class="h2-km">Каталог</h2>
                <div class="grid main_catalog_section">
                    @forelse($data as $item)
                        @include('blocks.card', ['item' => $item])
                    @empty
                        <p>Кина не будет</p>
                    @endforelse
                </div>
            </li>
            {{$data->links("pagination::bootstrap-4")}}
        </ul>
    </main>
@endsection
