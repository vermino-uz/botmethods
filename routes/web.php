<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BotController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate'); 
Route::post('/register', [AuthController::class, 'store'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Bot routes
    Route::resource('bots', BotController::class);
    Route::post('/bots/{bot}/send-message', [BotController::class, 'sendMessage'])->name('bots.send-message');
    Route::get('/bots/{bot}/updates', [BotController::class, 'getUpdates'])->name('bots.updates');

    // Custom bot action routes
    Route::post('/bots/{bot}/set-webhook', [BotController::class, 'setWebhook'])->name('bots.set-webhook');
    Route::post('/bots/{bot}/delete-webhook', [BotController::class, 'deleteWebhook'])->name('bots.delete-webhook');
    Route::get('/bots/{bot}/get-webhook-info', [BotController::class, 'getWebhookInfo'])->name('bots.get-webhook-info');
    Route::post('/bots/{bot}/forward-message', [BotController::class, 'forwardMessage'])->name('bots.forward-message');
    Route::post('/bots/{bot}/copy-message', [BotController::class, 'copyMessage'])->name('bots.copy-message');
    Route::post('/bots/{bot}/send-photo', [BotController::class, 'sendPhoto'])->name('bots.send-photo');
    Route::post('/bots/{bot}/send-audio', [BotController::class, 'sendAudio'])->name('bots.send-audio');
    Route::post('/bots/{bot}/send-document', [BotController::class, 'sendDocument'])->name('bots.send-document');
    Route::post('/bots/{bot}/send-video', [BotController::class, 'sendVideo'])->name('bots.send-video');
    Route::post('/bots/{bot}/send-animation', [BotController::class, 'sendAnimation'])->name('bots.send-animation');
    Route::post('/bots/{bot}/send-voice', [BotController::class, 'sendVoice'])->name('bots.send-voice');
    Route::post('/bots/{bot}/send-video-note', [BotController::class, 'sendVideoNote'])->name('bots.send-video-note');
    Route::post('/bots/{bot}/send-media-group', [BotController::class, 'sendMediaGroup'])->name('bots.send-media-group');
    Route::post('/bots/{bot}/send-location', [BotController::class, 'sendLocation'])->name('bots.send-location');
    Route::post('/bots/{bot}/edit-message-live-location', [BotController::class, 'editMessageLiveLocation'])->name('bots.edit-message-live-location');
    Route::post('/bots/{bot}/stop-message-live-location', [BotController::class, 'stopMessageLiveLocation'])->name('bots.stop-message-live-location');
    Route::post('/bots/{bot}/send-venue', [BotController::class, 'sendVenue'])->name('bots.send-venue');
    Route::post('/bots/{bot}/send-contact', [BotController::class, 'sendContact'])->name('bots.send-contact');
    Route::post('/bots/{bot}/send-poll', [BotController::class, 'sendPoll'])->name('bots.send-poll');
    Route::post('/bots/{bot}/send-dice', [BotController::class, 'sendDice'])->name('bots.send-dice');
    Route::post('/bots/{bot}/send-chat-action', [BotController::class, 'sendChatAction'])->name('bots.send-chat-action');
    Route::get('/bots/{bot}/get-user-profile-photos', [BotController::class, 'getUserProfilePhotos'])->name('bots.get-user-profile-photos');
    Route::get('/bots/{bot}/get-file', [BotController::class, 'getFile'])->name('bots.get-file');
    Route::post('/bots/{bot}/ban-chat-member', [BotController::class, 'banChatMember'])->name('bots.ban-chat-member');
    Route::post('/bots/{bot}/unban-chat-member', [BotController::class, 'unbanChatMember'])->name('bots.unban-chat-member');
    Route::post('/bots/{bot}/restrict-chat-member', [BotController::class, 'restrictChatMember'])->name('bots.restrict-chat-member');
    Route::post('/bots/{bot}/promote-chat-member', [BotController::class, 'promoteChatMember'])->name('bots.promote-chat-member');
    Route::post('/bots/{bot}/set-chat-administrator-custom-title', [BotController::class, 'setChatAdministratorCustomTitle'])->name('bots.set-chat-administrator-custom-title');
    Route::post('/bots/{bot}/ban-chat-sender-chat', [BotController::class, 'banChatSenderChat'])->name('bots.ban-chat-sender-chat');
    Route::post('/bots/{bot}/unban-chat-sender-chat', [BotController::class, 'unbanChatSenderChat'])->name('bots.unban-chat-sender-chat');
    Route::post('/bots/{bot}/set-chat-permissions', [BotController::class, 'setChatPermissions'])->name('bots.set-chat-permissions');
    Route::get('/bots/{bot}/export-chat-invite-link', [BotController::class, 'exportChatInviteLink'])->name('bots.export-chat-invite-link');
    Route::post('/bots/{bot}/create-chat-invite-link', [BotController::class, 'createChatInviteLink'])->name('bots.create-chat-invite-link');
    Route::post('/bots/{bot}/edit-chat-invite-link', [BotController::class, 'editChatInviteLink'])->name('bots.edit-chat-invite-link');
    Route::post('/bots/{bot}/revoke-chat-invite-link', [BotController::class, 'revokeChatInviteLink'])->name('bots.revoke-chat-invite-link');
    Route::post('/bots/{bot}/approve-chat-join-request', [BotController::class, 'approveChatJoinRequest'])->name('bots.approve-chat-join-request');
    Route::post('/bots/{bot}/decline-chat-join-request', [BotController::class, 'declineChatJoinRequest'])->name('bots.decline-chat-join-request');
    Route::post('/bots/{bot}/set-chat-photo', [BotController::class, 'setChatPhoto'])->name('bots.set-chat-photo');
    Route::post('/bots/{bot}/delete-chat-photo', [BotController::class, 'deleteChatPhoto'])->name('bots.delete-chat-photo');
    Route::post('/bots/{bot}/set-chat-title', [BotController::class, 'setChatTitle'])->name('bots.set-chat-title');
    Route::post('/bots/{bot}/set-chat-description', [BotController::class, 'setChatDescription'])->name('bots.set-chat-description');
    Route::post('/bots/{bot}/pin-chat-message', [BotController::class, 'pinChatMessage'])->name('bots.pin-chat-message');
    Route::post('/bots/{bot}/unpin-chat-message', [BotController::class, 'unpinChatMessage'])->name('bots.unpin-chat-message');
    Route::post('/bots/{bot}/unpin-all-chat-messages', [BotController::class, 'unpinAllChatMessages'])->name('bots.unpin-all-chat-messages');
    Route::post('/bots/{bot}/leave-chat', [BotController::class, 'leaveChat'])->name('bots.leave-chat');
    Route::get('/bots/{bot}/get-chat', [BotController::class, 'getChat'])->name('bots.get-chat');
    Route::get('/bots/{bot}/get-chat-administrators', [BotController::class, 'getChatAdministrators'])->name('bots.get-chat-administrators');
    Route::get('/bots/{bot}/get-chat-member-count', [BotController::class, 'getChatMemberCount'])->name('bots.get-chat-member-count');
    Route::get('/bots/{bot}/get-chat-member', [BotController::class, 'getChatMember'])->name('bots.get-chat-member');
    Route::post('/bots/{bot}/set-chat-sticker-set', [BotController::class, 'setChatStickerSet'])->name('bots.set-chat-sticker-set');
    Route::post('/bots/{bot}/delete-chat-sticker-set', [BotController::class, 'deleteChatStickerSet'])->name('bots.delete-chat-sticker-set');
    Route::post('/bots/{bot}/answer-callback-query', [BotController::class, 'answerCallbackQuery'])->name('bots.answer-callback-query');
    Route::post('/bots/{bot}/set-my-commands', [BotController::class, 'setMyCommands'])->name('bots.set-my-commands');
    Route::post('/bots/{bot}/delete-my-commands', [BotController::class, 'deleteMyCommands'])->name('bots.delete-my-commands');
    Route::get('/bots/{bot}/get-my-commands', [BotController::class, 'getMyCommands'])->name('bots.get-my-commands');
    Route::post('/bots/{bot}/set-chat-menu-button', [BotController::class, 'setChatMenuButton'])->name('bots.set-chat-menu-button');
    Route::get('/bots/{bot}/get-chat-menu-button', [BotController::class, 'getChatMenuButton'])->name('bots.get-chat-menu-button');
    Route::post('/bots/{bot}/set-my-default-administrator-rights', [BotController::class, 'setMyDefaultAdministratorRights'])->name('bots.set-my-default-administrator-rights');
    Route::get('/bots/{bot}/get-my-default-administrator-rights', [BotController::class, 'getMyDefaultAdministratorRights'])->name('bots.get-my-default-administrator-rights');
    Route::post('/bots/{bot}/edit-message-text', [BotController::class, 'editMessageText'])->name('bots.edit-message-text');
    Route::post('/bots/{bot}/edit-message-caption', [BotController::class, 'editMessageCaption'])->name('bots.edit-message-caption');
    Route::post('/bots/{bot}/edit-message-media', [BotController::class, 'editMessageMedia'])->name('bots.edit-message-media');
    Route::post('/bots/{bot}/edit-message-reply-markup', [BotController::class, 'editMessageReplyMarkup'])->name('bots.edit-message-reply-markup');
    Route::post('/bots/{bot}/stop-poll', [BotController::class, 'stopPoll'])->name('bots.stop-poll');
    Route::post('/bots/{bot}/delete-message', [BotController::class, 'deleteMessage'])->name('bots.delete-message');
    Route::post('/bots/{bot}/send-sticker', [BotController::class, 'sendSticker'])->name('bots.send-sticker');
    Route::get('/bots/{bot}/get-sticker-set', [BotController::class, 'getStickerSet'])->name('bots.get-sticker-set');
    Route::post('/bots/{bot}/upload-sticker-file', [BotController::class, 'uploadStickerFile'])->name('bots.upload-sticker-file');
    Route::post('/bots/{bot}/create-new-sticker-set', [BotController::class, 'createNewStickerSet'])->name('bots.create-new-sticker-set');
    Route::post('/bots/{bot}/add-sticker-to-set', [BotController::class, 'addStickerToSet'])->name('bots.add-sticker-to-set');
    Route::post('/bots/{bot}/set-sticker-position-in-set', [BotController::class, 'setStickerPositionInSet'])->name('bots.set-sticker-position-in-set');
    Route::post('/bots/{bot}/delete-sticker-from-set', [BotController::class, 'deleteStickerFromSet'])->name('bots.delete-sticker-from-set');
    Route::post('/bots/{bot}/set-sticker-emoji-list', [BotController::class, 'setStickerEmojiList'])->name('bots.set-sticker-emoji-list');
    Route::post('/bots/{bot}/set-sticker-keywords', [BotController::class, 'setStickerKeywords'])->name('bots.set-sticker-keywords');
    Route::post('/bots/{bot}/set-sticker-mask-position', [BotController::class, 'setStickerMaskPosition'])->name('bots.set-sticker-mask-position');
    Route::post('/bots/{bot}/set-sticker-set-title', [BotController::class, 'setStickerSetTitle'])->name('bots.set-sticker-set-title');
    Route::post('/bots/{bot}/set-sticker-set-thumbnail', [BotController::class, 'setStickerSetThumbnail'])->name('bots.set-sticker-set-thumbnail');
    Route::post('/bots/{bot}/set-custom-emoji-sticker-set-thumbnail', [BotController::class, 'setCustomEmojiStickerSetThumbnail'])->name('bots.set-custom-emoji-sticker-set-thumbnail');
    Route::post('/bots/{bot}/delete-sticker-set', [BotController::class, 'deleteStickerSet'])->name('bots.delete-sticker-set');
    Route::post('/bots/{bot}/answer-inline-query', [BotController::class, 'answerInlineQuery'])->name('bots.answer-inline-query');
    Route::post('/bots/{bot}/answer-web-app-query', [BotController::class, 'answerWebAppQuery'])->name('bots.answer-web-app-query');
    Route::post('/bots/{bot}/send-invoice', [BotController::class, 'sendInvoice'])->name('bots.send-invoice');
    Route::post('/bots/{bot}/create-invoice-link', [BotController::class, 'createInvoiceLink'])->name('bots.create-invoice-link');
    Route::post('/bots/{bot}/answer-shipping-query', [BotController::class, 'answerShippingQuery'])->name('bots.answer-shipping-query');
    Route::post('/bots/{bot}/answer-pre-checkout-query', [BotController::class, 'answerPreCheckoutQuery'])->name('bots.answer-pre-checkout-query');
    Route::post('/bots/{bot}/set-passport-data-errors', [BotController::class, 'setPassportDataErrors'])->name('bots.set-passport-data-errors');
    Route::post('/bots/{bot}/send-game', [BotController::class, 'sendGame'])->name('bots.send-game');
    Route::post('/bots/{bot}/set-game-score', [BotController::class, 'setGameScore'])->name('bots.set-game-score');
    Route::get('/bots/{bot}/get-game-high-scores', [BotController::class, 'getGameHighScores'])->name('bots.get-game-high-scores');
    Route::post('/bots/{bot}/log-out', [BotController::class, 'logOut'])->name('bots.log-out');
    Route::post('/bots/{bot}/close', [BotController::class, 'close'])->name('bots.close');
});

Route::fallback(function () {
    return view('errors.404');
});
