<?php

use App\Http\Controllers\Bookmark;
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

Route::controller(Bookmark::class)->group(function () {
    Route::get('/bookmarks', [Bookmark::class, 'index']);
    Route::post('/{userId}/bookmarks', [Bookmark::class, 'store']);
    Route::get('/bookmarks/{bookmarkId}', [Bookmark::class, 'show']);
    Route::put('/bookmarks/{bookmark}', [Bookmark::class, 'update']);
    Route::delete('/bookmarks/{bookmark}', [Bookmark::class, 'destroy']);
});
