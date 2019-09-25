<?php

namespace App\Observers;

use App\Models\Service;
use App\Observers\BaseObserver;

class ServiceObserver extends BaseObserver
{
    /**
     * Handle the service "created" event.
     *
     * @param  \App\Models\Service  $service
     * @return void
     */
    public function created(Service $service)
    {
        $description = "Service " . $service->service_name . ' (port: ' . $service->port . ') ' . __FUNCTION__ . ' for IP: ' . $service->ip->ip;
        $service->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($service, true)]);
        $this->makeScreenshots($service);
    }

    /**
     * Handle the service "updated" event.
     *
     * @param  \App\Models\Service  $service
     * @return void
     */
    public function updated(Service $service)
    {
        $description = "Service " . $service->service_name . ' (port: ' . $service->port . ') ' . __FUNCTION__ . ' for IP: ' . $service->ip->ip;
        $changes = $this->getModelChanges($service);
        $service->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => $changes]);
    }

    /**
     * Handle the service "deleted" event.
     *
     * @param  \App\Models\Service  $service
     * @return void
     */
    public function deleted(Service $service)
    {
        $description = "Service " . $service->service_name . ' (port: ' . $service->port . ') ' . __FUNCTION__ . ' for IP: ' . $service->ip->ip;
        $service->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($service, true)]);
    }

    /**
     * Handle the service "restored" event.
     *
     * @param  \App\Models\Service  $service
     * @return void
     */
    public function restored(Service $service)
    {
        $description = "Service " . $service->service_name . ' (port: ' . $service->port . ') ' . __FUNCTION__ . ' for IP: ' . $service->ip->ip;
        $service->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($service, true)]);
    }

    /**
     * Handle the service "force deleted" event.
     *
     * @param  \App\Models\Service  $service
     * @return void
     */
    public function forceDeleted(Service $service)
    {
        $description = "Service " . $service->service_name . ' (port: ' . $service->port . ') ' . __FUNCTION__ . ' for IP: ' . $service->ip->ip;
        $service->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($service, true)]);
    }

    private function makeScreenshots(Service $service)
    {
        foreach($service->ip->dnsRecords as $record)
        {
            $url = $service->getScheme() .'://'. $record->getDnsName();
            if ($service->port != 80 && $service->port != 443)
            {
                $url .= ':' . $service->port;
            } 
            ExecuteScreenshot::dispatch($url, $record->getDnsName(), $service->port);
        }

    }
}
