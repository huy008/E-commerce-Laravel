<?php

use App\Models\PermissionController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LoginMiddleware;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PostCatalogueController;
use App\Http\Controllers\Backend\UserCatalogueController;
use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard/index', [DashboardController::class, "index"])->name('dashboard.index')->middleware('admin');

Route::group(['prefix' => 'user'], function () {
    Route::get('index', [UserController::class, "index"])->name('user.index')->middleware('admin');
    Route::get('create', [UserController::class, "create"])->name('user.create')->middleware('admin');
    Route::post('store', [UserController::class, "store"])->name('user.store')->middleware('admin');
    Route::get('{id}/edit', [UserController::class, "edit"])->name('user.edit')->middleware('admin');
    Route::get('{id}/delete', [UserController::class, "delete"])->name('user.delete')->middleware('admin');
    Route::post('{id}/update', [UserController::class, "update"])->name('user.update')->middleware('admin');
    Route::post('{id}/destroy', [UserController::class, "destroy"])->name('user.destroy')->middleware('admin');
});

Route::group(['prefix' => 'user/catalogue'], function () {
    Route::get('index', [UserCatalogueController::class, "index"])->name('user.catalogue.index')->middleware('admin');
    Route::get('create', [UserCatalogueController::class, "create"])->name('user.catalogue.create')->middleware('admin');
    Route::post('store', [UserCatalogueController::class, "store"])->name('user.catalogue.store')->middleware('admin');
    Route::get('{id}/edit', [UserCatalogueController::class, "edit"])->name('user.catalogue.edit')->middleware('admin');
    Route::get('{id}/delete', [UserCatalogueController::class, "delete"])->name('user.catalogue.delete')->middleware('admin');
    Route::post('{id}/update', [UserCatalogueController::class, "update"])->name('user.catalogue.update')->middleware('admin');
    Route::post('{id}/destroy', [UserCatalogueController::class, "destroy"])->name('user.catalogue.destroy')->middleware('admin');
});
Route::group(['prefix' => 'language'], function () {
    Route::get('index', [LanguageController::class, "index"])->name('language.index')->middleware('admin');
    Route::get('create', [LanguageController::class, "create"])->name('language.create')->middleware('admin');
    Route::post('store', [LanguageController::class, "store"])->name('language.store')->middleware('admin');
    Route::get('{id}/edit', [LanguageController::class, "edit"])->name('language.edit')->middleware('admin');
    Route::get('{id}/delete', [LanguageController::class, "delete"])->name('language.delete')->middleware('admin');
    Route::post('{id}/update', [LanguageController::class, "update"])->name('language.update')->middleware('admin');
    Route::post('{id}/destroy', [LanguageController::class, "destroy"])->name('language.destroy')->middleware('admin');
});

Route::group(['prefix' => 'post/catalogue'], function () {
    Route::get('index', [PostCatalogueController::class, "index"])->name('post.catalogue.index')->middleware('admin');
    Route::get('create', [PostCatalogueController::class, "create"])->name('post.catalogue.create')->middleware('admin');
    Route::post('store', [PostCatalogueController::class, "store"])->name('post.catalogue.store')->middleware('admin');
    Route::get('{id}/edit', [PostCatalogueController::class, "edit"])->name('post.catalogue.edit')->middleware('admin');
    Route::get('{id}/delete', [PostCatalogueController::class, "delete"])->name('post.catalogue.delete')->middleware('admin');
    Route::post('{id}/update', [PostCatalogueController::class, "update"])->name('post.catalogue.update')->middleware('admin');
    Route::post('{id}/destroy', [PostCatalogueController::class, "destroy"])->name('post.catalogue.destroy')->middleware('admin');
});

Route::group(['prefix' => 'post'], function () {
    Route::get('index', [PostController::class, "index"])->name('post.index')->middleware('admin');
    Route::get('create', [PostController::class, "create"])->name('post.create')->middleware('admin');
    Route::post('store', [PostController::class, "store"])->name('post.store')->middleware('admin');
    Route::get('{id}/edit', [PostController::class, "edit"])->name('post.edit')->middleware('admin');
    Route::get('{id}/delete', [PostController::class, "delete"])->name('post.delete')->middleware('admin');
    Route::post('{id}/update', [PostController::class, "update"])->name('post.update')->middleware('admin');
    Route::post('{id}/destroy', [PostController::class, "destroy"])->name('post.destroy')->middleware('admin');
});
Route::group(['prefix' => 'permission'], function () {
    Route::get('index', [PermissionController::class, "index"])->name('permission.index')->middleware('admin');
    Route::get('create', [PermissionController::class, "create"])->name('permission.create')->middleware('admin');
    Route::permission('store', [PermissionController::class, "store"])->name('permission.store')->middleware('admin');
    Route::get('{id}/edit', [PermissionController::class, "edit"])->name('permission.edit')->middleware('admin');
    Route::get('{id}/delete', [PermissionController::class, "delete"])->name('permission.delete')->middleware('admin');
    Route::permission('{id}/update', [PermissionController::class, "update"])->name('permission.update')->middleware('admin');
    Route::permission('{id}/destroy', [PermissionController::class, "destroy"])->name('permission.destroy')->middleware('admin');
});

Route::get('admin', [AuthController::class, "index"])->name('auth.admin')->middleware('login');

Route::post('login', [AuthController::class, "login"])->name('auth.login');
Route::get('logout', [AuthController::class, "logout"])->name('auth.logout');
 
Route::get('ajax/location/getLocation', [LocationController::class, "getLocation"])->name('ajax.location.index')->middleware('admin');
Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, "changeStatus"])->name('ajax.dashboard.changeStatus')->middleware('admin');
Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboardController::class, "changeStatusAll"])->name('ajax.dashboard.changeStatusAll')->middleware('admin');