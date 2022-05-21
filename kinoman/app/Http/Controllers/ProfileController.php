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
                    f.*
                FROM user_lists ul
                LEFT JOIN lists l ON ul.list_id = l.id
                LEFT JOIN films f ON ul.film_id = f.id
                WHERE user_id = :id
                ORDER BY l.id, f.release_year DESC', ['id' => $id]
            );

            $arr = [];
            foreach($result as $row) {
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
            $id = Auth::id();

            $result = DB::table('user_lists as ul')
                ->join('lists as l', 'ul.list_id', '=', 'l.id')
                ->join('films as f', 'ul.film_id', '=', 'f.id')
                ->select('ul.list_id as collection_id','l.name','f.*')
                ->where([['user_id', '=', $id], ['list_id', '=', $list_id]])
                ->orderBy('list_id')
                ->orderBy('release_year', 'DESC')
                ->paginate(8);

            $arr = [];
            foreach($result as $row) {
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

            DB::table('user_lists')
                ->where('user_id', $user_id)
                ->where('film_id', $film_id)
                ->where('list_id', $old_list_id)
                ->delete();

            DB::table('user_lists')
                ->insertOrIgnore(
                    ['user_id' => $user_id, 'film_id' => $film_id, 'list_id' => $new_list_id]
                );

            return $new_list_id;
        } else {
            return 0;
        }
    }
}
