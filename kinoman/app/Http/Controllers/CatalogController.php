<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\FilmInfoView;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CatalogController extends Controller
{
    public function index(): Factory|View|Application
    {
        $films = Film::query()
            ->orderBy('release_year', 'desc')
            ->paginate(8);

        return view('catalog', ['data' => $films]);
    }

    public function film(FilmInfoView $filmInfoView): Factory|View|Application
    {
        return view('film', ['data' => $filmInfoView]);
    }
}
