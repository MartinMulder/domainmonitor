<?php

namespace App\Jobs;

use App\Models\Ip;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExecuteReverseDnsLookup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ip = null;

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
        $this->ip->reverse_dns = gethostbyaddr($this->ip->ip);
        $this->ip->save();

        if (count($this->ip->getChanges()) > 0) {
            Log::info('Updated reverse DNS for ip: '.$this->ip->ip );
            Log::debug(print_r($this->ip->getChanges(), true));
        } else {
            Log::debug('Reverse DNS lookup for ip: ' . $this->ip->ip . " reverse dns: " . $this->ip->reverse_dns);
        }
    }
}
