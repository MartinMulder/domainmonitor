<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Domain;
use Iodev\Whois\Whois;
use App\Models\whoisData;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Iodev\Whois\Loaders\CurlLoader;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Redis;

class ExecuteWhois implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $domain;
    
    // Whois connection
    private $whois;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Domain $domain)
    {
        $this->domain = $domain;

        // Set proxy options
        $loader = new CurlLoader();
        $loader->replaceOptions([
            CURLOPT_PROXYTYPE => CURLPROXY_SOCKS5,
            CURLOPT_PROXY => '127.0.0.1:9080',
        ]);

        // Create and execute whois service
        $this->whois = Whois::create($loader);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('Try to whois ' . $this->domain->domain);
        if (count(explode('.', $this->domain->domain)) <= 2)
        {
            Redis::throttle('whois')->allow(1)->every(20)->block(30)->then(function () {
                $d = Domain::find($this->domain->id);
                $info = $this->whois->loadDomainInfo($this->domain->domain);

                // Fetch the persisted data
                $whoisData = $d->whoisData ?: new whoisData;

                // Update persisted data
                $whoisData->domainname = $d->domain;
                $whoisData->active = implode(',', $info->getStates());
                $whoisData->dnsservers = implode(',', $info->getNameServers());
                $whoisData->owner = $info->getOwner();
                $whoisData->registrar = $info->getRegistrar();
                $whoisData->creationDate = ($info->getCreationDate() == 0) ? null : $info->getCreationDate();
                $whoisData->expirationDate = ($info->getExpirationDate() == 0) ? null : $info->getExpirationDate();
                $whoisData->whoisserver = $info->getWhoisServer();
                $whoisData->rawData = $info->getResponse()->getText();

                // Update the last whois date
                $d->last_whois_date = Carbon::now();

                // Save the data
                $d->whoisData()->save($whoisData);
                $d->save();
            }, function () {
                return $this->release(rand(200, 500));
            });            
        } else {
            Log::warning('Skipping whois for domain: ' . $this->domain->domain . ". Not a toplevel domain");
        }
        

        return redirect()->back();
    }
}
