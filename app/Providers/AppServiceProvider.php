<?php

namespace App\Providers;

use App\Models\Domain;
use App\Models\Ip;
use App\Models\WhoisData;
use App\Observers\DomainObserver;
use App\Observers\IpObserver;
use App\Observers\WhoisDataObserver;
use Illuminate\Support\ServiceProvider;

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
    }
}
