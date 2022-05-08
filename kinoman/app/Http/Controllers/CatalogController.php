<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Catalog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CatalogController extends Controller
{
    public function index(): Factory|View|Application
    {
        $films = Catalog::query()
            ->orderBy('release_year', 'desc')
            ->paginate(8);

        return view('catalog', ['data' => $films]);
    }

    public function film(Film $film): Factory|View|Application
    {
        return view('film', ['data' => $film]);
    }
}
