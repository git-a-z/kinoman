<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    public function index(): Factory|View|Application
    {
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

        return view('collections', ['data' => $arr]);
    }
}
