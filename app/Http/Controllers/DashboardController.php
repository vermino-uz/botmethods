<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; // Add this line
use App\Models\Bot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $bots = Bot::where('user_id', $user->id)->get();

        return view('dashboard.index', [
            'bots' => $bots
        ]);
    }
}
