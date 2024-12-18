<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\BookmarkController;
use Illuminate\Http\Request;
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
Route::post('/login', [AuthenticatedSessionController::class, 'apiLogin'])->name('login');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(BookmarkController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/bookmarks/{user}', [BookmarkController::class, 'index'])->name('bookmark.index');
    Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmark.store');
    Route::get('/bookmarks/{bookmark}', [BookmarkController::class, 'show'])->name('bookmark.show');
    Route::put('/bookmarks/{bookmark}', [BookmarkController::class, 'update'])->name('bookmark.update');
    Route::delete('/bookmarks/{bookmark}', [BookmarkController::class, 'destroy'])->name('bookmark.destroy');
});
