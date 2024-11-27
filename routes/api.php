<?php

use App\Http\Controllers\BotController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    // Bot management routes
    Route::get('/bots', [BotController::class, 'index']);
    Route::post('/bots', [BotController::class, 'store']);
    Route::get('/bots/{bot}', [BotController::class, 'show']);
    Route::put('/bots/{bot}', [BotController::class, 'update']);
    Route::delete('/bots/{bot}', [BotController::class, 'destroy']);

    // Telegram API interaction routes
    Route::post('/bots/{bot}/send-message', [BotController::class, 'sendMessage']);
    Route::post('/bots/{bot}/send-photo', [BotController::class, 'sendPhoto']);
    Route::post('/bots/{bot}/send-document', [BotController::class, 'sendDocument']);
    Route::get('/bots/{bot}/updates', [BotController::class, 'getUpdates']);
    Route::post('/bots/{bot}/set-webhook', [BotController::class, 'setWebhook']);
    Route::delete('/bots/{bot}/delete-webhook', [BotController::class, 'deleteWebhook']);
    Route::get('/bots/{bot}/webhook-info', [BotController::class, 'getWebhookInfo']);
});
