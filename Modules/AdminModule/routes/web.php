<?php
use Modules\AdminModule\App\Http\Controllers\AdminModuleController;
use Modules\AdminModule\App\Http\Controllers\AdminItemController;
use Modules\AdminModule\App\Http\Controllers\AdminCategoryController;
use Modules\AdminModule\App\Http\Controllers\AdminUserController;
use Modules\FrontendModule\App\Http\Controllers\CompanySettingController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


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

Route::group([], function () {
    Route::resource('adminmodule', AdminModuleController::class)->names('adminmodule');
});



Route::middleware(['isAdmin'])->group(function () {
    // Admin
    Route::get('/admin/panel',  [AdminModuleController::class, 'panel'])->name('admin.dashboard');

    Route::get('/admin/items', [AdminItemController::class, 'index'])->name('admin.index');
    Route::get('/admin/userList', [AdminUserController::class, 'index'])->name('admin.userList');

    Route::get('/admin/filter', [AdminItemController::class, 'filter'])->name('admin.filter');
    Route::post('/admin/filter', [AdminItemController::class, 'filter'])->name('admin.filter');

    Route::get('/admin/create', [AdminItemController::class, 'create'])->name('admin.create');
    Route::post('/admin/create', [AdminItemController::class, 'create'])->name('admin.create');

    Route::post('/admin/store', [AdminItemController::class, 'store'])->name('admin.store');

    Route::get('/admin/edit/{id}', [AdminItemController::class, 'edit'])->name('admin.edit');
    Route::post('/admin/edit/{id}', [AdminItemController::class, 'edit'])->name('admin.edit');

    Route::put('/admin/update/{id}', [AdminItemController::class, 'update'])->name('admin.update');
    Route::put('/admin/photo/update/{id}', [AdminItemController::class, 'photoUpdate'])->name('admin.photo.update');

    Route::get('/admin/delete/{id}', [AdminItemController::class, 'delete'])->name('admin.delete');
    Route::delete('/admin/delete/{id}', [AdminItemController::class, 'delete'])->name('admin.delete'); 

    Route::get('/admin/category', [AdminCategoryController::class, 'index'])->name('admin.category.index');
    Route::get('/admin/category/view/{id}', [AdminCategoryController::class, 'view'])->name('admin.category.view');

    Route::get('/admin/category/create', [AdminCategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/admin/category/create', [AdminCategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/admin/category/store', [AdminCategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/admin/category/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin.category.edit');
    Route::post('/admin/category/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('/admin/category/update/{id}', [AdminCategoryController::class, 'update'])->name('admin.category.update');
    Route::get('/admin/category/delete/{id}', [AdminCategoryController::class, 'delete'])->name('admin.category.delete');
    Route::delete('/admin/category/delete/{id}', [AdminCategoryController::class, 'delete'])->name('admin.category.delete'); 

    Route::get('/admin/company_setting/view',  [CompanySettingController::class, 'viewCompanySetting'])
    ->name('company_setting.view');
    Route::get('/admin/company_setting/edit',  [CompanySettingController::class, 'editCompanySetting'])
    ->name('company_setting.edit');
    Route::get('/admin/company_setting/save',  [CompanySettingController::class, 'storeCompanySetting'])
    ->name('company_setting.save');
    Route::put('/admin/company_setting/save',  [CompanySettingController::class, 'storeCompanySetting'])
    ->name('company_setting.save');

    Route::get('/admin/company_setting/photos/edit',  [CompanySettingController::class, 'uploadPhotos'])
    ->name('company_setting.photos.edit');
    Route::get('/admin/company_setting/photos/save1',  [CompanySettingController::class, 'storeuploadPhotos1'])
    ->name('company_setting.photos.save1');
    Route::put('/admin/company_setting/photos/save1',  [CompanySettingController::class, 'storeuploadPhotos1'])
    ->name('company_setting.photos.save1');

    Route::get('/admin/company_setting/photos/save2',  [CompanySettingController::class, 'storeuploadPhotos2'])
    ->name('company_setting.photos.save2');
    Route::put('/admin/company_setting/photos/save2',  [CompanySettingController::class, 'storeuploadPhotos2'])
    ->name('company_setting.photos.save2');
    
    
});


