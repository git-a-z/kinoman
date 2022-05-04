<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;

class CollectionController extends Controller
{
    #[NoReturn] public function index(): Factory|View|Application
    {
//        $films = Film::query()
//            ->orderBy('release_year', 'desc')
//            ->paginate(8);
//
//        return view('catalog', ['data' => $films]);

        $result = DB::select(
            'SELECT
                c.name,
                f.*
            FROM film_collections fc
            LEFT JOIN films f ON fc.film_id = f.id
            LEFT JOIN collections c ON fc.collection_id = c.id
            ORDER BY fc.collection_id, f.release_year DESC'
        );

        $arr = [];
        foreach($result as $row) {
            $arr[$row->name][] = $row;
        }

//        dd($arr);
        return view('collections', ['data' => $arr]);
    }
}
