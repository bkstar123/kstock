<?php

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
// Login redirect
Route::redirect('/', '/cms/admins/login');

// Dashboard
Route::get('/cms/dashboard', function () {
    return view('cms.dashboard');
})->name('dashboard.index')
  ->middleware('bkscms-auth:admins');

// Setting routes
Route::group(
    [
        'prefix' => 'cms',
        'middleware' => [
            'bkscms-auth:admins',
        ]
    ],
    function () {
        Route::get('settings', 'SettingController@index')
            ->name('cms.settings.index')
            ->middleware('bkscms-auth:admins');
        Route::post('settings', 'SettingController@update')
            ->name('cms.settings.update')
            ->middleware('bkscms-auth:admins');
    }
);