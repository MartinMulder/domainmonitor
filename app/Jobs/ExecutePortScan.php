<?php

namespace App\Jobs;

use App\Models\Ip;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Nmap\Nmap;

class ExecutePortScan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $ip;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Ip $ip)
    {
        $this->ip = $ip;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Select the total list of current services
        $servicesToDelete = $this->ip->services()->pluck('id')->toArray();

        Redis::throttle('portscan')->allow(1)->every(240)->block(300)->then(function () {
            $hosts = Nmap::create()
                ->enableServiceInfo()
                ->setTimeout(240)
                ->scan([$this->ip->ip]);
            if (is_array($hosts) && count($hosts) == 1)
            {
                $host = array_pop($hosts);
                foreach ( $host->getOpenPorts() as $port )
                {
                    Log::info('Add or update: ' . $port->getService()->getName());
                    $result = $this->ip->services()->updateOrCreate(
                        // Define the unique fields to select the record
                        [
                            'port' => $port->getNumber(),
                            'protocol' => $port->getProtocol(),
                        ],
                        // Dynamic data
                        [
                            'state' => $port->getState(),
                            'service_name' => $port->getService()->getName(),
                            'product' => $port->getService()->getProduct(),
                            'version' => $port->getService()->getVersion(),
                        ]
                    );

                    if ($result->wasRecentlyCreated) {
                        Log::info('Created service record: '.$port->getService()->getName().' ('.$port->getNumber().')');
                    } else {
                        // Remove id from toDelete Array
                        $servicesToDelete = array_diff($servicesToDelete, [$result->id]);

                        if (count($result->getChanges()) > 0) {
                            Log::info('Created service record: '.$port->getService()->getName().' ('.$port->getNumber().')');
                            Log::debug(print_r($result->getChanges(), true));
                        }
                    }
                }

            } else {
                throw new Log::warning('invalid nmap response: ' . print_r($hosts, true));
            }
        }, function () {
            return $this->release(rand(200, 500));
        });     
    }
}
