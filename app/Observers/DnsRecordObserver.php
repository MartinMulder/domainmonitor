<?php

namespace App\Observers;

use App\Models\DnsRecord;

class DnsRecordObserver
{
    /**
     * Handle the dns record "created" event.
     *
     * @param  \App\Models\DnsRecord  $dnsRecord
     * @return void
     */
    public function created(DnsRecord $dnsRecord)
    {
        $description = "DNS Record " . $dnsRecord->name . '.' . $dnsRecord->domain->domain . ' ' . __FUNCTION__;
        $dnsRecord->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($dnsRecord, true)]);
    }

    /**
     * Handle the dns record "updated" event.
     *
     * @param  \App\Models\DnsRecord  $dnsRecord
     * @return void
     */
    public function updated(DnsRecord $dnsRecord)
    {
        $description = "DNS Record " . $dnsRecord->name . '.' . $dnsRecord->domain->domain . ' ' . __FUNCTION__;
        $changes = $this->getModelChanges($dnsRecord);
        $dnsRecord->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => $changes]);
    }

    /**
     * Handle the dns record "deleted" event.
     *
     * @param  \App\Models\DnsRecord  $dnsRecord
     * @return void
     */
    public function deleted(DnsRecord $dnsRecord)
    {
        $description = "DNS Record " . $dnsRecord->name . '.' . $dnsRecord->domain->domain . ' ' . __FUNCTION__;
        $dnsRecord->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($dnsRecord, true)]);
    }

    /**
     * Handle the dns record "restored" event.
     *
     * @param  \App\Models\DnsRecord  $dnsRecord
     * @return void
     */
    public function restored(DnsRecord $dnsRecord)
    {
        $description = "DNS Record " . $dnsRecord->name . '.' . $dnsRecord->domain->domain . ' ' . __FUNCTION__;
        $dnsRecord->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($dnsRecord, true)]);
    }

    /**
     * Handle the dns record "force deleted" event.
     *
     * @param  \App\Models\DnsRecord  $dnsRecord
     * @return void
     */
    public function forceDeleted(DnsRecord $dnsRecord)
    {
        $description = "DNS Record " . $dnsRecord->name . '.' . $dnsRecord->domain->domain . ' ' . __FUNCTION__;
        $dnsRecord->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($dnsRecord, true)]);
    }
}
