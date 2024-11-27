<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BotController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bots = Bot::where('user_id', Auth::id())->get();
        return view('bots.index', compact('bots'));
    }

    public function create()
    {
        return view('bots.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'token' => ['required', 'string', 'unique:bots,token']
        ]);

        $bot = new Bot();
        $bot->user_id = Auth::id();
        $bot->name = $validated['name'];
        $bot->token = $validated['token'];
        $bot->save();

        return redirect()->route('bots.show', $bot)
            ->with('success', 'Bot created successfully');
    }

    public function show(Bot $bot)
    {
        // Ensure user can only view their own bots
        if ($bot->user_id !== Auth::id()) {
            abort(403);
        }

        return view('bots.show', compact('bot'));
    }

    public function destroy(Bot $bot)
    {
        // Ensure user can only delete their own bots
        if ($bot->user_id !== Auth::id()) {
            abort(403);
        }

        $bot->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Bot deleted successfully');
    }

    public function sendMessage(Request $request, Bot $bot)
    {
        // Ensure user can only use their own bots
        if ($bot->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'chat_id' => ['required', 'string'],
            'message' => ['required', 'string']
        ]);

        $response = Http::post("https://api.telegram.org/bot{$bot->token}/sendMessage", [
            'chat_id' => $validated['chat_id'],
            'text' => $validated['message'],
            'parse_mode' => 'HTML'
        ]);

        return response()->json($response->json());
    }

    public function getUpdates(Bot $bot)
    {
        // Ensure user can only use their own bots
        if ($bot->user_id !== Auth::id()) {
            abort(403);
        }

        $response = Http::get("https://api.telegram.org/bot{$bot->token}/getUpdates");

        return response()->json($response->json());
    }
}
