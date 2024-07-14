<?php


use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LoginMiddleware;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\PostController;

use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Backend\SystemController;
use App\Http\Controllers\Backend\GenerateController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\PostCatalogueController;
use App\Http\Controllers\Backend\UserCatalogueController;
use App\Http\Controllers\Ajax\AttributeController as AjaxAttributeController;
use App\Http\Controllers\Ajax\DashboardController as AjaxDashboardController;
          use App\Http\Controllers\Backend\AttributeCatalogueController;
          use App\Http\Controllers\Backend\AttributeController;

          use App\Http\Controllers\Backend\ProductCatalogueController;
          use App\Http\Controllers\Backend\ProductController;
     //@@new-use@@
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

    Route::get('permission', [UserCatalogueController::class, "permission"])->name('user.catalogue.permission')->middleware('admin');
    Route::get('index', [UserCatalogueController::class, "index"])->name('user.catalogue.index')->middleware('admin');
    Route::get('create', [UserCatalogueController::class, "create"])->name('user.catalogue.create')->middleware('admin');
    Route::post('store', [UserCatalogueController::class, "store"])->name('user.catalogue.store')->middleware('admin');
    Route::get('{id}/edit', [UserCatalogueController::class, "edit"])->name('user.catalogue.edit')->middleware('admin');
    Route::get('{id}/delete', [UserCatalogueController::class, "delete"])->name('user.catalogue.delete')->middleware('admin');
    Route::post('{id}/update', [UserCatalogueController::class, "update"])->name('user.catalogue.update')->middleware('admin');
    Route::post('{id}/destroy', [UserCatalogueController::class, "destroy"])->name('user.catalogue.destroy')->middleware('admin');
    Route::post('updatePermission', [UserCatalogueController::class, "updatePermission"])->name('user.catalogue.updatePermission')->middleware('admin');
   
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


Route::group(['prefix' => 'generate'], function () {
    Route::get('index', [GenerateController::class, "index"])->name('generate.index')->middleware('admin');
    Route::get('create', [GenerateController::class, "create"])->name('generate.create')->middleware('admin');
    Route::post('store', [GenerateController::class, "store"])->name('generate.store')->middleware('admin');
    Route::get('{id}/edit', [GenerateController::class, "edit"])->name('generate.edit')->middleware('admin');
    Route::get('{id}/delete', [GenerateController::class, "delete"])->name('generate.delete')->middleware('admin');
    Route::post('{id}/update', [GenerateController::class, "update"])->name('generate.update')->middleware('admin');
    Route::post('{id}/destroy', [GenerateController::class, "destroy"])->name('generate.destroy')->middleware('admin');
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
    Route::post('store', [PermissionController::class, "store"])->name('permission.store')->middleware('admin');
    Route::get('{id}/edit', [PermissionController::class, "edit"])->name('permission.edit')->middleware('admin');
    Route::get('{id}/delete', [PermissionController::class, "delete"])->name('permission.delete')->middleware('admin');
    Route::post('{id}/update', [PermissionController::class, "update"])->name('permission.update')->middleware('admin');
    Route::post('{id}/destroy', [PermissionController::class, "destroy"])->name('permission.destroy')->middleware('admin');
});


 


     Route::group(['prefix' => 'attribute/catalogue'], function () {
      Route::get('index', [AttributeCatalogueController::class, "index"])->name('attribute.catalogue.index')->middleware('admin');
    Route::get('create', [AttributeCatalogueController::class, "create"])->name('attribute.catalogue.create')->middleware('admin');
    Route::post('store', [AttributeCatalogueController::class, "store"])->name('attribute.catalogue.store')->middleware('admin');
    Route::get('{id}/edit', [AttributeCatalogueController::class, "edit"])->name('attribute.catalogue.edit')->middleware('admin');
    Route::get('{id}/delete', [AttributeCatalogueController::class, "delete"])->name('attribute.catalogue.delete')->middleware('admin');
    Route::post('{id}/update', [AttributeCatalogueController::class, "update"])->name('attribute.catalogue.update')->middleware('admin');
    Route::post('{id}/destroy', [AttributeCatalogueController::class, "destroy"])->name('attribute.catalogue.destroy')->middleware('admin');
});
  
     Route::group(['prefix' => 'attribute'], function () {
      Route::get('index', [AttributeController::class, "index"])->name('attribute.index')->middleware('admin');
    Route::get('create', [AttributeController::class, "create"])->name('attribute.create')->middleware('admin');
    Route::post('store', [AttributeController::class, "store"])->name('attribute.store')->middleware('admin');
    Route::get('{id}/edit', [AttributeController::class, "edit"])->name('attribute.edit')->middleware('admin');
    Route::get('{id}/delete', [AttributeController::class, "delete"])->name('attribute.delete')->middleware('admin');
    Route::post('{id}/update', [AttributeController::class, "update"])->name('attribute.update')->middleware('admin');
    Route::post('{id}/destroy', [AttributeController::class, "destroy"])->name('attribute.destroy')->middleware('admin');
});

     Route::group(['prefix' => 'product/catalogue'], function () {
      Route::get('index', [ProductCatalogueController::class, "index"])->name('product.catalogue.index')->middleware('admin');
    Route::get('create', [ProductCatalogueController::class, "create"])->name('product.catalogue.create')->middleware('admin');
    Route::post('store', [ProductCatalogueController::class, "store"])->name('product.catalogue.store')->middleware('admin');
    Route::get('{id}/edit', [ProductCatalogueController::class, "edit"])->name('product.catalogue.edit')->middleware('admin');
    Route::get('{id}/delete', [ProductCatalogueController::class, "delete"])->name('product.catalogue.delete')->middleware('admin');
    Route::post('{id}/update', [ProductCatalogueController::class, "update"])->name('product.catalogue.update')->middleware('admin');
    Route::post('{id}/destroy', [ProductCatalogueController::class, "destroy"])->name('product.catalogue.destroy')->middleware('admin');
});
     Route::group(['prefix' => 'product'], function () {
      Route::get('index', [ProductController::class, "index"])->name('product.index')->middleware('admin');
    Route::get('create', [ProductController::class, "create"])->name('product.create')->middleware('admin');
    Route::post('store', [ProductController::class, "store"])->name('product.store')->middleware('admin');
    Route::get('{id}/edit', [ProductController::class, "edit"])->name('product.edit')->middleware('admin');
    Route::get('{id}/delete', [ProductController::class, "delete"])->name('product.delete')->middleware('admin');
    Route::post('{id}/update', [ProductController::class, "update"])->name('product.update')->middleware('admin');
    Route::post('{id}/destroy', [ProductController::class, "destroy"])->name('product.destroy')->middleware('admin');
});
Route::group(['prefix' => 'system'], function () {
    Route::get('index', [SystemController::class, "index"])->name('system.index')->middleware('admin');
    Route::post('store', [SystemController::class, "store"])->name('system.store')->middleware('admin');

});
//@@new-route@@

Route::get('admin', [AuthController::class, "index"])->name('auth.admin')->middleware('login');

Route::post('login', [AuthController::class, "login"])->name('auth.login');
Route::get('logout', [AuthController::class, "logout"])->name('auth.logout');
 
Route::get('ajax/location/getLocation', [LocationController::class, "getLocation"])->name('ajax.location.index')->middleware('admin');
Route::get('/ajax/attribute/getAttribute', [AjaxAttributeController::class, "getAttribute"])->name('ajax.attribute.index')->middleware('admin');
Route::post('ajax/dashboard/changeStatus', [AjaxDashboardController::class, "changeStatus"])->name('ajax.dashboard.changeStatus')->middleware('admin');
Route::post('ajax/dashboard/changeStatusAll', [AjaxDashboardController::class, "changeStatusAll"])->name('ajax.dashboard.changeStatusAll')->middleware('admin');