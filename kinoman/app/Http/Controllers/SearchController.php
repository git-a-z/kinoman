<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Genre;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(): Factory|View|Application
    {
        $data = [];
        $genres = Genre::all();

        $actors = DB::select(
            'SELECT DISTINCT
                id,
                firstname,
                lastname
            FROM persons
            LEFT JOIN film_persons ON id = person_id
            WHERE position_id < 5
            ORDER BY lastname');

        $years = [
            ['id' => 2020, 'name' => '2020-2022'],
            ['id' => 2010, 'name' => '2010-2019'],
            ['id' => 2000, 'name' => '2000-2009'],
            ['id' => 1990, 'name' => '1990-1999'],
            ['id' => 1980, 'name' => '1980-1989'],
            ['id' => 1970, 'name' => '1970-1979'],
            ['id' => 1960, 'name' => '1960-1969'],
            ['id' => 1950, 'name' => '1950-1959'],
            ['id' => 1940, 'name' => '1940-1949'],
            ['id' => 1930, 'name' => '1930-1939'],
            ['id' => 1920, 'name' => '1920-1929'],
            ['id' => 1910, 'name' => '1910-1919'],
            ['id' => 1900, 'name' => '1900-1909'],
        ];

        return view('search', [
            'data' => $data,
            'genres' => $genres,
            'actors' => $actors,
            'years' => $years,
        ]);
    }

    public function filter(Request $request): Factory|View|Application
    {
        $content = $request->getContent();
        parse_str($content, $params);

        $result = [];
        $searchString = $params['searchString'];

        if (!empty($searchString)) {
            $str = "%$searchString%";
            $result = DB::select(
            "SELECT *
                FROM films
                WHERE title LIKE :str1
                OR rus_title LIKE :str2
                ORDER BY release_year DESC", [
                    ':str1' => $str,
                    ':str2' => $str,
                ]
            );
        }

        return view('blocks.collection', ['collection' => $result]);;
    }
}
