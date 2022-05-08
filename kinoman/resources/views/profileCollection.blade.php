@extends('layouts.main')

@section('title')
    @parent Список профиля
@endsection

@section('pageName')
    @parent Список профиля
@endsection

@section('content')
    @include('blocks.collections', ['data' => $data, 'route' => $route])
    {{$pagination->links("pagination::bootstrap-4")}}
@endsection
