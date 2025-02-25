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

        // Get bot information from Telegram
        $response = Http::get("https://api.telegram.org/bot{$validated['token']}/getMe");
        
        if (!$response->successful()) {
            return back()->withErrors(['token' => 'Invalid bot token'])->withInput();
        }

        $botInfo = $response->json();
        if (!isset($botInfo['ok']) || !$botInfo['ok']) {
            return back()->withErrors(['token' => 'Failed to get bot information'])->withInput();
        }

        $bot = new Bot();
        $bot->user_id = Auth::id();
        $bot->name = $validated['name'] ?? $botInfo['result']['first_name'];
        $bot->token = $validated['token'];
        $bot->username = $botInfo['result']['username'];
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
            'chat_id' => 'required|string',
            'message' => 'required|string',
        ]);

        $response = Http::post("https://api.telegram.org/bot{$bot->token}/sendMessage", [
            'chat_id' => $validated['chat_id'],
            'text' => $validated['message'],
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

    public function setWebhook(Request $request, Bot $bot)
    {
        // Ensure user can only use their own bots
        if ($bot->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'url' => 'required|url',
        ]);
        
        Http::get("https://api.telegram.org/bot{$bot->token}/deleteWebhook?drop_pending_updates=true");

        $response = Http::post("https://api.telegram.org/bot{$bot->token}/setWebhook", [
            'url' => $validated['url'],
        ]);

        return response()->json($response->json());
    }

    public function getWebhookInfo(Bot $bot)
    {
        // Ensure user can only use their own bots
        if ($bot->user_id !== Auth::id()) {
            abort(403);
        }

        $response = Http::get("https://api.telegram.org/bot{$bot->token}/getWebhookInfo");

        return response()->json($response->json());
    }

    public function deleteWebhook(Bot $bot)
    {
        if ($bot->user_id !== Auth::id()) {
            abort(403);
        }

        $response = Http::post("https://api.telegram.org/bot{$bot->token}/deleteWebhook");

        return response()->json($response->json());
    }

    public function sendPhoto(Request $request, Bot $bot)
    {
        $validated = $request->validate([
            'chat_id' => 'required|string',
            'photo' => 'required|url',
        ]);

        $response = Http::post("https://api.telegram.org/bot{$bot->token}/sendPhoto", [
            'chat_id' => $validated['chat_id'],
            'photo' => $validated['photo'],
        ]);

        return response()->json($response->json());
    }

    public function sendAudio(Request $request, Bot $bot)
    {
        $validated = $request->validate([
            'chat_id' => 'required|string',
            'audio' => 'required|url',
        ]);

        $response = Http::post("https://api.telegram.org/bot{$bot->token}/sendAudio", [
            'chat_id' => $validated['chat_id'],
            'audio' => $validated['audio'],
        ]);

        return response()->json($response->json());
    }

    public function sendVideo(Request $request, Bot $bot)
    {
        $validated = $request->validate([
            'chat_id' => 'required|string',
            'video' => 'required|url',
        ]);

        $response = Http::post("https://api.telegram.org/bot{$bot->token}/sendVideo", [
            'chat_id' => $validated['chat_id'],
            'video' => $validated['video'],
        ]);

        return response()->json($response->json());
    }

    public function forwardMessage(Request $request)
    {
        // Placeholder for forwardMessage functionality
    }

    public function copyMessage(Request $request)
    {
        // Placeholder for copyMessage functionality
    }

    public function sendSticker(Request $request)
    {
        // Placeholder for sendSticker functionality
    }

    public function getStickerSet(Request $request)
    {
        // Placeholder for getStickerSet functionality
    }

    public function uploadStickerFile(Request $request)
    {
        // Placeholder for uploadStickerFile functionality
    }

    public function createNewStickerSet(Request $request)
    {
        // Placeholder for createNewStickerSet functionality
    }

    public function addStickerToSet(Request $request)
    {
        // Placeholder for addStickerToSet functionality
    }

    public function setStickerPositionInSet(Request $request)
    {
        // Placeholder for setStickerPositionInSet functionality
    }

    public function deleteStickerFromSet(Request $request)
    {
        // Placeholder for deleteStickerFromSet functionality
    }

    public function setStickerEmojiList(Request $request)
    {
        // Placeholder for setStickerEmojiList functionality
    }

    public function setStickerKeywords(Request $request)
    {
        // Placeholder for setStickerKeywords functionality
    }

    public function setStickerMaskPosition(Request $request)
    {
        // Placeholder for setStickerMaskPosition functionality
    }

    public function setStickerSetTitle(Request $request)
    {
        // Placeholder for setStickerSetTitle functionality
    }

    public function setStickerSetThumbnail(Request $request)
    {
        // Placeholder for setStickerSetThumbnail functionality
    }

    public function setCustomEmojiStickerSetThumbnail(Request $request)
    {
        // Placeholder for setCustomEmojiStickerSetThumbnail functionality
    }

    public function deleteStickerSet(Request $request)
    {
        // Placeholder for deleteStickerSet functionality
    }

    public function answerInlineQuery(Request $request)
    {
        // Placeholder for answerInlineQuery functionality
    }

    public function answerWebAppQuery(Request $request)
    {
        // Placeholder for answerWebAppQuery functionality
    }

    public function sendInvoice(Request $request)
    {
        // Placeholder for sendInvoice functionality
    }

    public function createInvoiceLink(Request $request)
    {
        // Placeholder for createInvoiceLink functionality
    }

    public function answerShippingQuery(Request $request)
    {
        // Placeholder for answerShippingQuery functionality
    }

    public function answerPreCheckoutQuery(Request $request)
    {
        // Placeholder for answerPreCheckoutQuery functionality
    }

    public function setPassportDataErrors(Request $request)
    {
        // Placeholder for setPassportDataErrors functionality
    }

    public function sendGame(Request $request)
    {
        // Placeholder for sendGame functionality
    }

    public function setGameScore(Request $request)
    {
        // Placeholder for setGameScore functionality
    }

    public function getGameHighScores(Request $request)
    {
        // Placeholder for getGameHighScores functionality
    }

    public function logOut(Request $request)
    {
        // Placeholder for logOut functionality
    }

    public function close(Request $request)
    {
        // Placeholder for close functionality
    }

    public function editMessageText(Request $request)
    {
        // Placeholder for editMessageText functionality
    }

    public function editMessageCaption(Request $request)
    {
        // Placeholder for editMessageCaption functionality
    }

    public function editMessageMedia(Request $request)
    {
        // Placeholder for editMessageMedia functionality
    }

    public function editMessageReplyMarkup(Request $request)
    {
        // Placeholder for editMessageReplyMarkup functionality
    }

    public function stopPoll(Request $request)
    {
        // Placeholder for stopPoll functionality
    }

    public function deleteMessage(Request $request)
    {
        // Placeholder for deleteMessage functionality
    }

    public function banChatMember(Request $request)
    {
        // Placeholder for banChatMember functionality
    }

    public function unbanChatMember(Request $request)
    {
        // Placeholder for unbanChatMember functionality
    }

    public function restrictChatMember(Request $request)
    {
        // Placeholder for restrictChatMember functionality
    }

    public function promoteChatMember(Request $request)
    {
        // Placeholder for promoteChatMember functionality
    }

    public function setChatAdministratorCustomTitle(Request $request)
    {
        // Placeholder for setChatAdministratorCustomTitle functionality
    }

    public function banChatSenderChat(Request $request)
    {
        // Placeholder for banChatSenderChat functionality
    }

    public function unbanChatSenderChat(Request $request)
    {
        // Placeholder for unbanChatSenderChat functionality
    }

    public function setChatPermissions(Request $request)
    {
        // Placeholder for setChatPermissions functionality
    }

    public function exportChatInviteLink(Request $request)
    {
        // Placeholder for exportChatInviteLink functionality
    }

    public function createChatInviteLink(Request $request)
    {
        // Placeholder for createChatInviteLink functionality
    }

    public function editChatInviteLink(Request $request)
    {
        // Placeholder for editChatInviteLink functionality
    }

    public function revokeChatInviteLink(Request $request)
    {
        // Placeholder for revokeChatInviteLink functionality
    }

    public function approveChatJoinRequest(Request $request)
    {
        // Placeholder for approveChatJoinRequest functionality
    }

    public function declineChatJoinRequest(Request $request)
    {
        // Placeholder for declineChatJoinRequest functionality
    }

    public function setChatPhoto(Request $request)
    {
        // Placeholder for setChatPhoto functionality
    }

    public function deleteChatPhoto(Request $request)
    {
        // Placeholder for deleteChatPhoto functionality
    }

    public function setChatTitle(Request $request)
    {
        // Placeholder for setChatTitle functionality
    }

    public function setChatDescription(Request $request)
    {
        // Placeholder for setChatDescription functionality
    }

    public function pinChatMessage(Request $request)
    {
        // Placeholder for pinChatMessage functionality
    }

    public function unpinChatMessage(Request $request)
    {
        // Placeholder for unpinChatMessage functionality
    }

    public function unpinAllChatMessages(Request $request)
    {
        // Placeholder for unpinAllChatMessages functionality
    }

    public function leaveChat(Request $request)
    {
        // Placeholder for leaveChat functionality
    }

    public function getChat(Request $request)
    {
        // Placeholder for getChat functionality
    }

    public function getChatAdministrators(Request $request)
    {
        // Placeholder for getChatAdministrators functionality
    }

    public function getChatMemberCount(Request $request)
    {
        // Placeholder for getChatMemberCount functionality
    }

    public function getChatMember(Request $request)
    {
        // Placeholder for getChatMember functionality
    }

    public function setChatStickerSet(Request $request)
    {
        // Placeholder for setChatStickerSet functionality
    }

    public function deleteChatStickerSet(Request $request)
    {
        // Placeholder for deleteChatStickerSet functionality
    }

    public function answerCallbackQuery(Request $request)
    {
        // Placeholder for answerCallbackQuery functionality
    }

    public function setMyCommands(Request $request)
    {
        // Placeholder for setMyCommands functionality
    }

    public function deleteMyCommands(Request $request)
    {
        // Placeholder for deleteMyCommands functionality
    }

    public function getMyCommands(Request $request)
    {
        // Placeholder for getMyCommands functionality
    }

    public function setChatMenuButton(Request $request)
    {
        // Placeholder for setChatMenuButton functionality
    }

    public function getChatMenuButton(Request $request)
    {
        // Placeholder for getChatMenuButton functionality
    }

    public function setMyDefaultAdministratorRights(Request $request)
    {
        // Placeholder for setMyDefaultAdministratorRights functionality
    }

    public function getMyDefaultAdministratorRights(Request $request)
    {
        // Placeholder for getMyDefaultAdministratorRights functionality
    }
}
