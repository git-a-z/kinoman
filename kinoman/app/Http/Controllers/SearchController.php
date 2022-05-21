<?php

namespace App\Http\Controllers;

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

        $actors = DB::table('persons')
            ->distinct()
            ->select('id', 'firstname', 'lastname')
            ->leftJoin('film_persons', 'id', '=', 'person_id')
            ->where('position_id', '<', 5)
            ->orderBy('lastname')
            ->get();

        $years[] = ['id' => 2020, 'name' => '2020-2022'];
        for ($i = 2010; $i >= 1900; $i -= 10) {
            $lastYear = $i + 9;
            $years[] = ['id' => $i, 'name' => "$i-$lastYear"];
        }

        return view('search', [
            'data' => $data,
            'genres' => $genres,
            'actors' => $actors,
            'years' => $years,
        ]);
    }

    public function filter(Request $request): Factory|View|Application
    {
        $params = $request->all();
        $searchString = $params['searchString'];
        $genreStr = 'genre_id_';
        $genres = [];
        $actorStr = 'actor_id_';
        $actors = [];
        $yearStr = 'year_id_';
        $years = [];
        $result = [];

        foreach ($params as $key => $value) {
            if (str_contains($key, $genreStr)) {
                $genres[] = str_replace($genreStr, '', $key);
            }
            if (str_contains($key, $actorStr)) {
                $actors[] = str_replace($actorStr, '', $key);
            }
            if (str_contains($key, $yearStr)) {
                $startYear = str_replace($yearStr, '', $key);
                $years = array_merge($years, range($startYear, $startYear + 9));
            }
        }

        if (!empty($searchString) || !empty($genres) || !empty($actors) || !empty($years)) {
            $query = DB::table('films as f')
                ->distinct()
                ->select('f.*')
                ->selectRaw('0 as collection_id');

            if (!empty($genres)) {
                $query = $query->leftJoin('film_genres as fg', 'f.id', '=', 'fg.film_id');
            }

            if (!empty($actors)) {
                $query = $query->leftJoin('film_persons as fp', 'f.id', '=', 'fp.film_id');
            }

            if (!empty($searchString)) {
                $str = "%$searchString%";
                $query = $query->where(function ($query) use ($str) {
                    $query->where('title', 'like', $str);
                    $query->orWhere('rus_title', 'like', $str);
                });
            }

            if (!empty($genres)) {
                $query = $query->where(function ($query) use ($genres) {
                    $query->whereIn('fg.genre_id', $genres);
                });
            }

            if (!empty($actors)) {
                $query = $query->where(function ($query) use ($actors) {
                    $query->whereIn('fp.person_id', $actors);
                    $query->where('fp.position_id', '<', 5);
                });
            }

            if (!empty($years)) {
                sort($years);
                $query = $query->where(function ($query) use ($years) {
                    $query->whereIn('release_year', $years);
                });
            }

            $result = $query
                ->orderBy('release_year', 'desc')
                ->get();
        }

        return view('blocks.cards_single', ['data' => $result]);
    }
}
