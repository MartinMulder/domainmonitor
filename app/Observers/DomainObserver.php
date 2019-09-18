<?php

namespace App\Observers;

use App\Jobs\ExecuteWhois;
use App\Models\AuditLog;
use App\Models\Domain;
use App\Observers\BaseObserver;

class DomainObserver extends BaseObserver
{
    /**
     * Handle the domain "created" event.
     *
     * @param  \App\Models\Domain  $domain
     * @return void
     */
    public function created(Domain $domain)
    {
        $description = "Domain " . $domain->domain . ' ' . __FUNCTION__;
        $domain->auditLogs()->create(['action' => 'created', 'description' => $description, 'result' => print_r($domain, true)]);
        ExecuteWhois::dispatch($domain);
    }

    /**
     * Handle the domain "updated" event.
     *
     * @param  \App\Models\Domain  $domain
     * @return void
     */
    public function updated(Domain $domain)
    {
        $changes = $this->getModelChanges($domain);
        $description = "Domain " . $domain->domain . ' ' . __FUNCTION__;
        $domain->auditLogs()->create(['action' => 'updated', 'description' => $description, 'result' => $changes]);
    }

    /**
     * Handle the domain "deleted" event.
     *
     * @param  \App\Models\Domain  $domain
     * @return void
     */
    public function deleted(Domain $domain)
    {
        $description = "Domain " . $domain->domain . ' ' . __FUNCTION__;
        $domain->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($domain, true)]);
    }

    /**
     * Handle the domain "restored" event.
     *
     * @param  \App\Models\Domain  $domain
     * @return void
     */
    public function restored(Domain $domain)
    {
        $description = "Domain " . $domain->domain . ' ' . __FUNCTION__;
        $domain->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($domain, true)]);
    }

    /**
     * Handle the domain "force deleted" event.
     *
     * @param  \App\Models\Domain  $domain
     * @return void
     */
    public function forceDeleted(Domain $domain)
    {
        $description = "Domain " . $domain->domain . ' ' . __FUNCTION__;
        $domain->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($domain, true)]);
    }
}
