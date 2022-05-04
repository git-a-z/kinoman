<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(): Factory|View|Application
    {
        if (Auth::check()) {
            $user = Auth::user();
            return view('profile', ['data' => $user]);
        } else {
            return view('auth.login');
        }
    }
}
