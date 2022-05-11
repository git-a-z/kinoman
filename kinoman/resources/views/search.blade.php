@extends('layouts.main')

@section('title')
    @parent Поиск
@endsection

@section('pageName')
    @parent Поиск
@endsection

@section('content')
    <main class="content">
        <ul>
            <li class="main_catalog">
                <h2 class="h2-km">Расширенный поиск</h2>
                <form id="searchForm">
                    <div class="wrap">
                        <main class="main_box">
                            <h2 class="main_box_h2">Искать фильм:</h2>
                            <div class="main_box_flex">
                                <div class="main_box_flex_text">
                                    <input type="text" name="searchString" class="main_box_text_input">
                                    <p class="main_box_text_input_p">Полное или частичное название фильма</p>
                                </div>
                                <details class="main_box_btn">
                                    <summary class="main_box_btn_summary">Жанры</summary>
                                    <div class="main_box_drop">
                                        @forelse($genres as $item)
                                            <label class="main_box_drop_a">
                                                <input type="checkbox" name="genre_id_{{$item->id}}"
                                                       class="main_box_drop_a_checkbox">
                                                <p class="main_box_drop_a_p"> {{$item->name}} </p>
                                            </label>
                                        @empty
                                        @endforelse
                                    </div>
                                </details>

                                <details class="main_box_btn">
                                    <summary class="main_box_btn_summary">Актеры</summary>
                                    <div class="main_box_drop">
                                        @forelse($actors as $item)
                                            <label class="main_box_drop_a">
                                                <input type="checkbox" data-genre_id="{{$item->id}}"
                                                       class="main_box_drop_a_checkbox">
                                                <p class="main_box_drop_a_p"> {{$item->firstname}} {{$item->lastname}} </p>
                                            </label>
                                        @empty
                                        @endforelse
                                    </div>
                                </details>

                                <details class="main_box_btn">
                                    <summary class="button_year">Годы выхода</summary>
                                    <div class="main_box_drop">
                                        @forelse($years as $item)
                                            <label class="main_box_drop_a">
                                                <input type="checkbox" data-genre_id="{{$item['id']}}"
                                                       class="main_box_drop_a_checkbox">
                                                <p class="main_box_drop_a_p"> {{$item['name']}} </p>
                                            </label>
                                        @empty
                                        @endforelse
                                    </div>
                                </details>
                                <button class="main_box_flex_btn" id="submit">Поиск</button>
                            </div>
                        </main>
                    </div>
                </form>
                <div id="search_results">
                    @include('blocks.collection', ['collection' => $data])
                </div>
            </li>
        </ul>
    </main>
@endsection
