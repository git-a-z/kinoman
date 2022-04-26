<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    public function index(): Factory|View|Application
    {
        $data = DB::select('SELECT * FROM films');
        return view('catalog', ['data' => $data]);
    }

    public function film($id): Factory|View|Application
    {
        $data = DB::select('SELECT * FROM films_info_view WHERE id = :id',
            ['id' => $id]);

        if (empty($data)) {
            return redirect('/catalog');
        }

        return view('film', ['data' => $data[0]]);
    }
}
