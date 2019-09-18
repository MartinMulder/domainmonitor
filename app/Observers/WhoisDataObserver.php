<?php

namespace App\Observers;

use App\Models\WhoisData;
use App\Observers\BaseObserver;

class WhoisDataObserver extends BaseObserver
{
    /**
     * Handle the whois data "created" event.
     *
     * @param  \App\Models\WhoisData  $whoisData
     * @return void
     */
    public function created(WhoisData $whoisData)
    {
        $description = "WhoisData " . $whoisData->domainname . ' ' . __FUNCTION__;
        $whoisData->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($whoisData, true)]);
    }

    /**
     * Handle the whois data "updated" event.
     *
     * @param  \App\Models\WhoisData  $whoisData
     * @return void
     */
    public function updated(WhoisData $whoisData)
    {
        $description = "WhoisData " . $whoisData->domainname . ' ' . __FUNCTION__;
        $changes = $this->getModelChanges($whoisData);
        $ip->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => $changes]);
    }

    /**
     * Handle the whois data "deleted" event.
     *
     * @param  \App\Models\WhoisData  $whoisData
     * @return void
     */
    public function deleted(WhoisData $whoisData)
    {
        $description = "WhoisData " . $whoisData->domainname . ' ' . __FUNCTION__;
        $whoisData->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($whoisData, true)]);
    }

    /**
     * Handle the whois data "restored" event.
     *
     * @param  \App\Models\WhoisData  $whoisData
     * @return void
     */
    public function restored(WhoisData $whoisData)
    {
        $description = "WhoisData " . $whoisData->domainname . ' ' . __FUNCTION__;
        $whoisData->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($whoisData, true)]);
    }

    /**
     * Handle the whois data "force deleted" event.
     *
     * @param  \App\Models\WhoisData  $whoisData
     * @return void
     */
    public function forceDeleted(WhoisData $whoisData)
    {
        $description = "WhoisData " . $whoisData->domainname . ' ' . __FUNCTION__;
        $whoisData->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($whoisData, true)]);
    }
}
