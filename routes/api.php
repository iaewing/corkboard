<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/bookmarks', function () {
//     return json_encode(\App\Models\Bookmark::all());
// });

Route::controller(BookmarkController::class)->group(function () {
    Route::get('/bookmarks', [BookmarkController::class, 'index']);
    Route::post('/bookmarks', [BookmarkController::class, 'store']);
    Route::get('/bookmarks/{bookmarkId}', [BookmarkController::class, 'show']);
    Route::put('/bookmarks/{bookmark}', [BookmarkController::class, 'update']);
    Route::delete('/bookmarks/{bookmark}', [BookmarkController::class, 'destroy']);
});
