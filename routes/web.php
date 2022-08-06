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

// Securities Symbols
Route::group(
    [
        'prefix' => 'cms',
        'middleware' => [
            'bkscms-auth:admins',
        ]
    ],
    function () {
        // index
        Route::get('financial-statements', 'SymbolController@listFinancialStatements')
            ->name('cms.financial.statements.index')
            ->middleware('bkscms-auth:admins');
        // pull
        Route::get('financial-statement/pull', function () {
            return view('cms.symbols.statements.pull');
        })->name('cms.financial.statements.pull')
          ->middleware('bkscms-auth:admins');
        Route::post('financial-statement/pull', 'SymbolController@pullFinancialStatement')
            ->name('cms.financial.statements.pull')
            ->middleware('bkscms-auth:admins');
        // show
        Route::get('financial-statements/{financial_statement}', 'SymbolController@showFinancialStatement')
            ->name('cms.financial.statements.show');
        // destroy
        Route::delete('financial-statements/{financial_statement}/destroy', 'SymbolController@destroyFinancialStatement')
        ->name('cms.financial.statements.destroy')
        ->middleware('can:financial.statements.destroy,financial_statement');
        Route::delete('financial-statements', 'SymbolController@massiveDestroyFinancialStatements')
        ->name('cms.financial.statements.massiveDestroy')
        ->middleware('can:financial.statements.massiveDestroy');
    }
);
