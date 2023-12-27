<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');

Route::get('/detail/{slug}', 'App\Http\Controllers\DetailController@index')->name('detail');

Route::post('/checkout/{id}', 'App\Http\Controllers\DetailController@process');

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', 'App\Http\Controllers\Admin\DashboardController@index')->name('dashboard');

        Route::resource('travel-package', 'App\Http\Controllers\Admin\TravelPackageController');
        Route::resource('gallery', 'App\Http\Controllers\Admin\GalleryController');
        Route::resource('transaction', 'App\Http\Controllers\Admin\TransactionController');
    });

Auth::routes(['verify' => true]);