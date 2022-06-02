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
                <div>
                    <img class="user_img" src="img/userfoto1.jpg">
                </div>
                <div class="user_info">
                    <p>Имя: {{$user->name}}</p>
                    <p>Email: {{$user->email}}</p>
                    @if ($user->show_public)
                        <p>Показывать профиль всем
                            <a href="{{$public_address}}" target="_blank">  ссылка </a>
                        </p>
                    @else
                        <p>Показывать профиль только мне</p>
                    @endif
                </div>
                <div>
                    <a href="{{route('profile_edit')}}"> Редактировать </a>
                </div>
            </div>
        </div>
        <div class="user_collections">
            @include('blocks.lists', ['data' => $data, 'route' => $route])
        </div>
    @endisset
@endsection
