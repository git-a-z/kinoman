<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Catalog;
use App\Models\UserList;
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
        $films = Catalog::query()
            ->orderBy('release_year', 'desc')
            ->paginate(8);

        return view('catalog', ['data' => $films]);
    }

    public function film(Film $film): Factory|View|Application
    {
        $lists = $this->getLists($film->getKey('id'));

        return view('film', [
            'data' => $film,
            'lists' => $lists
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
                LEFT JOIN user_lists ul ON id = list_id
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

    public function addDelFilmInList(Request $request): Factory|View|Application
    {
        $user_id = $request->user_id;
        $film_id = $request->film_id;
        $list_id = $request->list_id;
        $cur_list_id = $request->cur_list_id;

        if ($list_id) {
            DB::table('user_lists')
                ->where('user_id', $user_id)
                ->where('film_id', $film_id)
                ->where('list_id', $list_id)
                ->delete();
        } else {
            $userList = new UserList;
            $userList->user_id = $user_id;
            $userList->film_id = $film_id;
            $userList->list_id = $cur_list_id ;
            $userList->save();
        }

        $lists = $this->getLists($film_id);

        return view('blocks.film_lists', ['lists' => $lists]);
    }
}
