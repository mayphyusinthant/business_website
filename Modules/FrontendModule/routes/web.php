<?php

use Illuminate\Support\Facades\Route;
use Modules\FrontendModule\App\Http\Controllers\FrontendModuleController;
use Modules\FrontendModule\App\Http\Controllers\ItemController;
use Modules\FrontendModule\App\Http\Controllers\CompanySettingController;


use Illuminate\Foundation\Application;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

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
Route::get('/',  [CompanySettingController::class, 'dashboard'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->name('dashboard');

// Route::get('/aboutus', function () {
//     return Inertia::render('About');
// })->name('about');

Route::get('/dashboard',  [CompanySettingController::class, 'dashboard'])->name('dashboard');

Route::get('/aboutus', [CompanySettingController::class, 'aboutus'])->name('about');

Route::get('/items', function (){
    return Inertia::render('Item/Index');
})->name('items.index');

Route::get('/items/filter', function (){
    return Inertia::render('Item/Index');
})->name('items.filter');


Route::get('/items/view/{id}', [ItemController::class, 'view'])->name('items.view');

Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    // Route::post('/items/create', [ItemController::class, 'create'])->name('items.create');
    // Route::post('/items/store', [ItemController::class, 'store'])->name('items.store');
    
    // Route::get('/items/edit/{id}', [ItemController::class, 'edit'])->name('items.edit');
    // Route::post('/items/edit/{id}', [ItemController::class, 'edit'])->name('items.edit');
    // Route::put('/items/update/{id}', [ItemController::class, 'update'])->name('items.update');
    
    // Route::get('/items/delete/{id}', [ItemController::class, 'delete'])->name('items.delete');
    // Route::delete('/items/delete/{id}', [ItemController::class, 'delete'])->name('items.delete');

});