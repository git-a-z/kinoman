@extends('layouts.main')

@section('title')
    @parent Коллекция
@endsection

@section('pageName')
    @parent Коллекция
@endsection

@section('content')
    @include('blocks.lists', ['$data' => $data, 'route' => $route])
    {{$pagination->links("pagination::bootstrap-4")}}
@endsection
