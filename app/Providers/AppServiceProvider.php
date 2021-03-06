<?php

namespace App\Providers;

use App\Models\DnsRecord;
use App\Models\Domain;
use App\Models\Ip;
use App\Models\Service;
use App\Models\WhoisData;
use App\Models\ZoneFile;
use App\Observers\DnsRecordObserver;
use App\Observers\DomainObserver;
use App\Observers\IpObserver;
use App\Observers\ServiceObserver;
use App\Observers\WhoisDataObserver;
use App\Observers\ZoneFileObserver;
use Illuminate\Support\Facades\Blade;
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
        ZoneFile::observe(ZoneFileObserver::class);
        DnsRecord::observe(DnsRecordObserver::class);
        Service::observe(ServiceObserver::class);

        Blade::component('components.panel', 'panel');
    }
}
