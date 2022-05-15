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
                fc.collection_id,
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

        return view('collections', [
            'data' => $arr,
            'route' => 'collection'
        ]);
    }

    public function collection(int $id): Factory|View|Application
    {
        $result = DB::table('film_collections as fc')
            ->join('films as f', 'fc.film_id', '=', 'f.id')
            ->join('collections as c', 'fc.collection_id', '=', 'c.id')
            ->select('fc.collection_id','c.name','f.*')
            ->where([['fc.collection_id', '=', $id]])
            ->orderBy('collection_id')
            ->orderBy('release_year', 'DESC')
            ->paginate(8);

        $arr = [];
        foreach($result->items() as $row) {
            $arr[$row->name][] = $row;
        }

        return view('collection', [
            'data' => $arr,
            'pagination' => $result,
            'route' => 'collection'
        ]);
    }
}
