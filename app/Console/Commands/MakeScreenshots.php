<?php

namespace App\Console\Commands;

use App\Jobs\ExecuteScreenshot;
use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MakeScreenshots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:makeScreenshots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all the HTTP services and make a screenshot';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get all the HTTP based services
        $services = Service::http()->get();
        // Loop through the services and get al the dns entries pointing to it
        foreach ($services as $service)
        {
            //Log::debug('service: ' . $service->service_name . ' port: ' . $service->port);
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
}
