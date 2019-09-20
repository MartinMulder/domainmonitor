<?php

namespace App\Providers;

use App\Models\Domain;
use App\Models\Ip;
use App\Models\WhoisData;
use App\Observers\DomainObserver;
use App\Observers\IpObserver;
use App\Observers\WhoisDataObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        Ip::observe(IpObserver::class);
        Domain::observe(DomainObserver::class);
        WhoisData::observe(WhoisDataObserver::class);

        Blade::component('components.panel', 'panel');
    }
}
