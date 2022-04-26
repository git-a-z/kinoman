@extends('layouts.main')

@section('title')
    @parent Каталог
@endsection

@section('pageName')
    @parent Каталог
@endsection

@section('content')
    @forelse($data as $item)
        <hr>
        <h2>{{$item->rus_title}}</h2>
        <div>{{$item->release_year}}</div>
        <a href="{{route('film', $item->id)}}">
            <img class="img-small" src="{{'img/'.$item->image_path}}">
        </a>
    @empty
        <p>Кина не будет</p>
    @endforelse
@endsection
