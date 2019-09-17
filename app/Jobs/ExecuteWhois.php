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

class ExecuteWhois implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $domain;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('sleeping 10 sec');
        sleep(10);
        Log::debug('done sleeping');
        Log::debug('execute whois for domain:'.$this->domain->domain);

        // Set proxy options
        $loader = new CurlLoader();
        $loader->replaceOptions([
            CURLOPT_PROXYTYPE => CURLPROXY_SOCKS5,
            CURLOPT_PROXY => '127.0.0.1:9080',
        ]);

        // Create and execute whois service
        $whois = Whois::create($loader);
        $info = $whois->loadDomainInfo($this->domain->domain);

        // Fetch the persisted data
        $whoisData = $this->domain->whoisData ?: new whoisData;

        // Update persisted data
        $whoisData->domainname = $this->domain->domain;
        $whoisData->active = implode(',', $info->getStates());
        $whoisData->dnsservers = implode(',', $info->getNameServers());
        $whoisData->owner = $info->getOwner();
        $whoisData->registrar = $info->getRegistrar();
        $whoisData->creationDate = ($info->getCreationDate() == 0) ? null : $info->getCreationDate();
        $whoisData->expirationDate = ($info->getExpirationDate() == 0) ? null : $info->getExpirationDate();
        $whoisData->whoisserver = $info->getWhoisServer();
        $whoisData->rawData = $info->getResponse()->getText();

        // Update the last whois date
        $this->domain->last_whois_date = Carbon::now();

        // Save the data
        $this->domain->whoisData()->save($whoisData);
        $this->domain->save();

        return redirect()->back();
    }
}
