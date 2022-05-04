@extends('layouts.main')

@section('title')
    @parent Профиль
@endsection

@section('pageName')
    @parent Профиль
@endsection

@section('content')
    @isset($data)
        <h2>{{$data->name}}</h2>
        <div>{{$data->email}}</div>
    @endisset
@endsection
