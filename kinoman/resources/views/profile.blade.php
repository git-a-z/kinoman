@extends('layouts.main')

@section('title')
    @parent Профиль
@endsection

@section('pageName')
    @parent Профиль
@endsection

@section('content')
    @isset($data)
        <div class="position_container">
            <div class="profile_container">
                <div class="user_img">
                    <a href="#">
                        <img src="img/userfoto.svg">
                    </a>
                </div>
                <div class="user_info">
                    <h2>{{$user->name}}</h2>
                    <p>{{$user->email}}</p>
                    <p>приватный профиль</p>
                    <p>999 просмотренных фильмов</p>
                </div>
                <div class="profile_settings">
                    <a href="#"> редактировать профиль</a>
                </div>
            </div>
        </div>
        <div class="user_collections">
            
            @include('blocks.profilecollections', ['$data' => $data, 'route' => $route])
        </div>
    @endisset
@endsection
