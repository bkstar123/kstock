<?php

namespace App\Providers;

use App\Services\Symbols;
use App\Exceptions\Cms\Handler;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Services\Contracts\Symbols as SymbolsInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (preg_match('/^cms\/.+$/', request()->path())) {
            if (class_exists(Handler::class)) {
                app()->singleton(ExceptionHandler::class, Handler::class);
            }
        }
        $this->app->singleton(SymbolsInterface::class, Symbols::class);
    }
}
