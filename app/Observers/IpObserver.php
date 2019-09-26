<?php

namespace App\Observers;

use App\Jobs\ExecutePortScan;
use App\Jobs\ExecuteReverseDnsLookup;
use App\Models\AuditLog;
use App\Models\Ip;
use App\Observers\BaseObserver;
use Illuminate\Support\Facades\Log;

class IpObserver extends BaseObserver
{
    /**
     * Handle the ip "created" event.
     *
     * @param  \App\Models\Ip  $ip
     * @return void
     */
    public function created(Ip $ip)
    {
        $description = "IP " . $ip->ip . ' ' . __FUNCTION__;
        $ip->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($ip, true)]);
        ExecuteReverseDnsLookup::dispatch($ip);
        ExecutePortScan::dispatch($ip);
    }

    /**
     * Handle the ip "updated" event.
     *
     * @param  \App\Models\Ip  $ip
     * @return void
     */
    public function updated(Ip $ip)
    {
        $description = "IP " . $ip->ip . ' ' . __FUNCTION__;
        $changes = $this->getModelChanges($ip);
        $ip->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => $changes]);
    }

    /**
     * Handle the ip "deleted" event.
     *
     * @param  \App\Models\Ip  $ip
     * @return void
     */
    public function deleted(Ip $ip)
    {
        $description = "IP " . $ip->ip . ' ' . __FUNCTION__;
        $ip->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'deleted' => print_r($ip, true)]);
    }

    /**
     * Handle the ip "restored" event.
     *
     * @param  \App\Models\Ip  $ip
     * @return void
     */
    public function restored(Ip $ip)
    {
        $description = "IP " . $ip->ip . ' ' . __FUNCTION__;
        $ip->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'restored' => print_r($ip, true)]);
    }

    /**
     * Handle the ip "force deleted" event.
     *
     * @param  \App\Models\Ip  $ip
     * @return void
     */
    public function forceDeleted(Ip $ip)
    {
        $description = "IP " . $ip->ip . ' ' . __FUNCTION__;
        $ip->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'focceDeleted' => print_r($ip, true)]);
    }
}
