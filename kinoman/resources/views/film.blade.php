@extends('layouts.main')

@section('title')
    @parent Фильм
@endsection

@section('pageName')
    @parent Фильм
@endsection

@section('content')
    <h2>{{$data->rus_title}}</h2>
    <div>({{$data->title}})</div>
    <div>{{$data->release_year}} год</div>
    <div>{{$data->length_in_minutes}} мин.</div>
    <div>{{$data->genres}}</div>
    <div>Режиссер: {{$data->directors}}</div>
    <div>Актеры: {{$data->actors}}</div>
    <img src="{{'../img/'.$data->poster}}">
    <div>Описание: {{$data->about}}</div>
    <a href="/catalog">Назад</a>
@endsection
