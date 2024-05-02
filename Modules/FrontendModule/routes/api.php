<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use Modules\FrontendModule\App\Http\Controllers\FrontendModuleController;
use Modules\FrontendModule\App\Http\Controllers\ItemApiController;

use Illuminate\Foundation\Application;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('frontendmodule', fn (Request $request) => $request->user())->name('frontendmodule');
});


Route::get('items/filter', [ItemApiController::class, 'filter'])->name('items.filter');
Route::get('items/search', [ItemApiController::class, 'search'])->name('items.search');
Route::apiResource('items', ItemApiController::class)->except(['show']);
// Route::get('items/show/{id}', [ItemApiController::class, 'show'])->name('items.show');

