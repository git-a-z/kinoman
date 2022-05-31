<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    public function index(): Factory|View|Application
    {
        $query = DB::table('films as f')
            ->leftJoin('film_info as fi', 'f.id', '=', 'fi.film_id')
            ->select('f.*', 'fi.briefly')
            ->selectRaw('0 as collection_id, fi.briefly');

        if (Auth::check()) {
            $user_id = Auth::id();
            $list1_id = 1;
            $list2_id = 2;
            $list3_id = 3;
            $query = $query
                ->selectRaw('IFNULL(ul1.list_id, 0) AS is_chosen')
                ->leftJoin('user_list_films as ul1', function ($leftJoin) use ($user_id, $list1_id) {
                    $leftJoin->on('id', '=', 'ul1.film_id')
                        ->where('ul1.user_id', '=', $user_id)
                        ->where('ul1.list_id', '=', $list1_id);
                });
            $query = $query
                ->selectRaw('IFNULL(ul2.list_id, 0) AS is_favorite')
                ->leftJoin('user_list_films as ul2', function ($leftJoin) use ($user_id, $list2_id) {
                    $leftJoin->on('id', '=', 'ul2.film_id')
                        ->where('ul2.user_id', '=', $user_id)
                        ->where('ul2.list_id', '=', $list2_id);
                });
            $query = $query
                ->selectRaw('IFNULL(ul3.list_id, 0) AS is_must_see')
                ->leftJoin('user_list_films as ul3', function ($leftJoin) use ($user_id, $list3_id) {
                    $leftJoin->on('id', '=', 'ul3.film_id')
                        ->where('ul3.user_id', '=', $user_id)
                        ->where('ul3.list_id', '=', $list3_id);
                });
        }

        $films = $query
            ->orderBy('release_year', 'desc')
            ->paginate(8);

        return view('catalog', ['data' => $films]);
    }

    public function film(Film $film): Factory|View|Application
    {
        $film_id = $film->getKey('id');
        $lists = $this->getLists($film_id);
        $emojis = $this->getEmojis($film_id);

        return view('film', [
            'data' => $film,
            'lists' => $lists,
            'emojis' => $emojis
        ]);
    }

    public function getLists(int $film_id): array
    {
        $lists = [];

        if (Auth::check()) {
            $user_id = Auth::id();

            $lists = DB::select(
                'SELECT
                    l.*,
                    IFNULL(list_id, 0) AS list_id,
                    :cur_user_id AS user_id,
                    :cur_film_id AS film_id
                FROM lists l
                LEFT JOIN user_list_films ul ON id = list_id
                                               AND user_id = :user_id
                                               AND film_id = :film_id
                ORDER BY l.id', [
                    'user_id' => $user_id,
                    'cur_user_id' => $user_id,
                    'film_id' => $film_id,
                    'cur_film_id' => $film_id]
            );
        }

        return $lists;
    }

    public function getEmojis(int $film_id): array
    {
        if (Auth::check()) {
            $user_id = Auth::id();

            $emojis = DB::select(
                'SELECT
                    f.id,
                    IFNULL(ufe1.emoji_id, 0) AS is_good,
                    IFNULL(ufe2.emoji_id, 0) AS is_dull,
                    IFNULL(ufe3.emoji_id, 0) AS is_scary,
                    IFNULL(ufe4.emoji_id, 0) AS is_sad,
                    IFNULL(ufe5.emoji_id, 0) AS is_fun,
                    SUM(CASE WHEN fe.emoji_id = 1 THEN 1 ELSE 0 END) AS count_good,
                    SUM(CASE WHEN fe.emoji_id = 2 THEN 1 ELSE 0 END) AS count_dull,
                    SUM(CASE WHEN fe.emoji_id = 3 THEN 1 ELSE 0 END) AS count_scary,
                    SUM(CASE WHEN fe.emoji_id = 4 THEN 1 ELSE 0 END) AS count_sad,
                    SUM(CASE WHEN fe.emoji_id = 5 THEN 1 ELSE 0 END) AS count_fun
                FROM films f
                LEFT JOIN user_film_emojis ufe1 ON f.id = ufe1.film_id AND ufe1.user_id = :user_id1 AND ufe1.emoji_id = 1
                LEFT JOIN user_film_emojis ufe2 ON f.id = ufe2.film_id AND ufe2.user_id = :user_id2 AND ufe2.emoji_id = 2
                LEFT JOIN user_film_emojis ufe3 ON f.id = ufe3.film_id AND ufe3.user_id = :user_id3 AND ufe3.emoji_id = 3
                LEFT JOIN user_film_emojis ufe4 ON f.id = ufe4.film_id AND ufe4.user_id = :user_id4 AND ufe4.emoji_id = 4
                LEFT JOIN user_film_emojis ufe5 ON f.id = ufe5.film_id AND ufe5.user_id = :user_id5 AND ufe5.emoji_id = 5
                LEFT JOIN user_film_emojis fe ON f.id = fe.film_id
                WHERE f.id = :film_id
                GROUP BY f.id', [
                    'user_id1' => $user_id,
                    'user_id2' => $user_id,
                    'user_id3' => $user_id,
                    'user_id4' => $user_id,
                    'user_id5' => $user_id,
                    'film_id' => $film_id
                ]
            );
        } else {
            $emojis = DB::select(
                'SELECT
                    f.id,
                    0 AS is_good,
                    0 AS is_dull,
                    0 AS is_scary,
                    0 AS is_sad,
                    0 AS is_fun,
                    SUM(CASE WHEN fe.emoji_id = 1 THEN 1 ELSE 0 END) AS count_good,
                    SUM(CASE WHEN fe.emoji_id = 2 THEN 1 ELSE 0 END) AS count_dull,
                    SUM(CASE WHEN fe.emoji_id = 3 THEN 1 ELSE 0 END) AS count_scary,
                    SUM(CASE WHEN fe.emoji_id = 4 THEN 1 ELSE 0 END) AS count_sad,
                    SUM(CASE WHEN fe.emoji_id = 5 THEN 1 ELSE 0 END) AS count_fun
                FROM films f
                LEFT JOIN user_film_emojis fe ON f.id = fe.film_id
                WHERE f.id = :film_id
                GROUP BY f.id', ['film_id' => $film_id]
            );
        }

        return $emojis;
    }

    public function addDelFilmInList(Request $request): Factory|View|Application
    {
        $user_id = $request->user_id;
        $film_id = $request->film_id;
        $list_id = $request->list_id;
        $new_list_id = $request->new_list_id;

        if ($list_id) {
            DB::table('user_list_films')
                ->where('user_id', $user_id)
                ->where('film_id', $film_id)
                ->where('list_id', $list_id)
                ->delete();
        } else {
            DB::table('user_list_films')
                ->insertOrIgnore(
                    ['user_id' => $user_id, 'film_id' => $film_id, 'list_id' => $new_list_id]
                );
        }

        $lists = $this->getLists($film_id);

        return view('blocks.film_lists', ['lists' => $lists]);
    }
}
