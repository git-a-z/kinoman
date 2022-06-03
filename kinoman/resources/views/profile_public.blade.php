@extends('layouts.main')

@section('title')
    @parent Открытый профиль
@endsection

@section('pageName')
    @parent Открытый профиль
@endsection

@section('content')
    @isset($data)
        <div class="position_container">
            <div class="profile_container">
                <div>
                    <img class="user_img" src="../img/userfoto2.jpg">
                </div>
                <div class="user_info">
                    <p>Имя: {{$user->name}}</p>
                </div>
                <div class="profile_settings">
                    <p>Открытый профиль</p>
                </div>
            </div>
        </div>
        <div class="user_collections">
            @include('blocks.lists', ['data' => $data, 'route' => $route, 'show_list' => false])
        </div>
    @endisset
@endsection
