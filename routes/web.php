<?php

use App\Http\Controllers\{UserController, PanelController, WebhookController};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', fn () => redirect()->route('login'))->name('home');

Route::prefix('backend')->as('backend.')->middleware(['auth'])->group(function () {
    Route::get('/overview', [PanelController::class, 'overview']);
    Route::post('/premium', [PanelController::class, 'premium'])->name('premium');

    Route::middleware(['role:admin'])->resource('users', UserController::class);

});
Route::prefix('auth')->group( fn () => require __DIR__.'/auth.php');

// Proccess Webhook
Route::prefix('webhook')->group(function () {
    Route::post('/paystack', [WebhookController::class, 'paystack']);
});

