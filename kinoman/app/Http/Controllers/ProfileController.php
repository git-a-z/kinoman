<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
                'data' => [
                    'user' => $user,
                    'list' => $arr
                ]
            ]);
        } else {
            return view('auth.login');
        }
    }
}
