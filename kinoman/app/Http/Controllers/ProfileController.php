<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index(): Factory|View|Application
    {
        if (Auth::check()) {
            $user = Auth::user();
            $id = Auth::id();

            $result = DB::select(
                'SELECT
                ul.list_id AS collection_id,
                l.name,
                f.*,
                IFNULL(ul1.list_id, 0) AS is_chosen,
                IFNULL(ul2.list_id, 0) AS is_favorite,
                IFNULL(ul3.list_id, 0) AS is_must_see
            FROM user_list_films ul
            LEFT JOIN lists l ON ul.list_id = l.id
            LEFT JOIN films f ON ul.film_id = f.id
            LEFT JOIN user_list_films ul1 ON ul.film_id = ul1.film_id
                AND ul1.user_id = ul.user_id
                AND ul1.list_id = 1
            LEFT JOIN user_list_films ul2 ON ul.film_id = ul2.film_id
                AND ul2.user_id = ul.user_id
                AND ul2.list_id = 2
            LEFT JOIN user_list_films ul3 ON ul.film_id = ul3.film_id
                AND ul3.user_id = ul.user_id
                AND ul3.list_id = 3
            WHERE ul.user_id = :id
            ORDER BY l.id, f.release_year DESC', ['id' => $id]
            );

            $arr = [];
            foreach ($result as $row) {
                $arr[$row->name][] = $row;
            }

            return view('profile', [
                'data' => $arr,
                'user' => $user,
                'route' => 'profile_list'
            ]);
        } else {
            return view('auth.login');
        }
    }

    public function list(int $list_id): Factory|View|Application
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = Auth::id();
            $list1_id = 1;
            $list2_id = 2;
            $list3_id = 3;

            $query = DB::table('user_list_films as ul')
                ->join('lists as l', 'ul.list_id', '=', 'l.id')
                ->join('films as f', 'ul.film_id', '=', 'f.id')
                ->select('ul.list_id as collection_id', 'l.name', 'f.*');

            $query = $query
                ->selectRaw('IFNULL(ul1.list_id, 0) AS is_chosen')
                ->leftJoin('user_list_films as ul1', function ($leftJoin) use ($user_id, $list1_id) {
                    $leftJoin->on('ul.film_id', '=', 'ul1.film_id')
                        ->where('ul1.user_id', '=', $user_id)
                        ->where('ul1.list_id', '=', $list1_id);
                });
            $query = $query
                ->selectRaw('IFNULL(ul2.list_id, 0) AS is_favorite')
                ->leftJoin('user_list_films as ul2', function ($leftJoin) use ($user_id, $list2_id) {
                    $leftJoin->on('ul.film_id', '=', 'ul2.film_id')
                        ->where('ul2.user_id', '=', $user_id)
                        ->where('ul2.list_id', '=', $list2_id);
                });
            $query = $query
                ->selectRaw('IFNULL(ul3.list_id, 0) AS is_must_see')
                ->leftJoin('user_list_films as ul3', function ($leftJoin) use ($user_id, $list3_id) {
                    $leftJoin->on('ul.film_id', '=', 'ul3.film_id')
                        ->where('ul3.user_id', '=', $user_id)
                        ->where('ul3.list_id', '=', $list3_id);
                });

            $result = $query
                ->where([['ul.user_id', '=', $user_id], ['ul.list_id', '=', $list_id]])
                ->orderBy('ul.list_id')
                ->orderBy('release_year', 'DESC')
                ->paginate(8);

            $arr = [];
            foreach ($result as $row) {
                $arr[$row->name][] = $row;
            }

            return view('profile_list', [
                'data' => $arr,
                'user' => $user,
                'pagination' => $result,
                'route' => 'profile_list'
            ]);
        } else {
            return view('auth.login');
        }
    }

    public function moveFilmFromListToList(Request $request): int
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $new_list_id = $request->new_list_id;
            $film_id = $request->film_id;
            $old_list_id = $request->old_list_id;

            DB::table('user_list_films')
                ->where('user_id', $user_id)
                ->where('film_id', $film_id)
                ->where('list_id', $old_list_id)
                ->delete();

            DB::table('user_list_films')
                ->insertOrIgnore(
                    ['user_id' => $user_id, 'film_id' => $film_id, 'list_id' => $new_list_id]
                );

            return $new_list_id;
        } else {
            return 0;
        }
    }
}
