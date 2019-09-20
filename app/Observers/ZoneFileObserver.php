<?php

namespace App\Observers;

use App\Models\DnsRecord;
use App\Models\Domain;
use App\Models\ZoneFile;
use App\Observers\BaseObserver;
use Badcow\DNS\Parser\Parser;
use Illuminate\Support\Facades\Log;

class ZoneFileObserver extends BaseObserver
{

	// Variables used for parsing zoneFile content
	private $buf = null;
    private $domainname = null;

    /**
     * Handle the zone file "created" event.
     *
     * @param  \App\Models\ZoneFile  $zoneFile
     * @return void
     */
    public function created(ZoneFile $zoneFile)
    {
        $description = "ZoneFile " . $zoneFile->title . ' ' . __FUNCTION__;
        $zoneFile->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($zoneFile, true)]);
        
        // If not imported before
        if (!$zoneFile->imported)
        {
        	$this->importZone($zoneFile);
        }
    }

    /**
     * Handle the zone file "updated" event.
     *
     * @param  \App\Models\ZoneFile  $zoneFile
     * @return void
     */
    public function updated(ZoneFile $zoneFile)
    {
        $description = "ZoneFile " . $zoneFile->title . ' ' . __FUNCTION__;
        $changes = $this->getModelChanges($zoneFile);
        $zoneFile->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => $changes]);
    }

    /**
     * Handle the zone file "deleted" event.
     *
     * @param  \App\Models\ZoneFile  $zoneFile
     * @return void
     */
    public function deleted(ZoneFile $zoneFile)
    {
        $description = "ZoneFile " . $zoneFile->title . ' ' . __FUNCTION__;
        $zoneFile->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($zoneFile, true)]);
    }

    /**
     * Handle the zone file "restored" event.
     *
     * @param  \App\Models\ZoneFile  $zoneFile
     * @return void
     */
    public function restored(ZoneFile $zoneFile)
    {
        $description = "ZoneFile " . $zoneFile->title . ' ' . __FUNCTION__;
        $zoneFile->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($zoneFile, true)]);
    }

    /**
     * Handle the zone file "force deleted" event.
     *
     * @param  \App\Models\ZoneFile  $zoneFile
     * @return void
     */
    public function forceDeleted(ZoneFile $zoneFile)
    {
        $description = "ZoneFile " . $zoneFile->title . ' ' . __FUNCTION__;
        $zoneFile->auditLogs()->create(['action' => __FUNCTION__, 'description' => $description, 'result' => print_r($zoneFile, true)]);
    }


    private function importZone(ZoneFile $zoneFile) 
    {
    	$zoneList = [];
        $domainModel = null;

        
        $data = $zoneFile->content;
        $split_data = preg_split("/((\r?\n)|(\r\n?))/", $data);

        foreach ($split_data as $line) {
            // Check if a new zone files begun and get the domainname
            if (preg_match('/\$ORIGIN (.*)./', $line, $matches)) {
                // Flush the current buffer and clear if
                $this->flushBuffer($zoneList, $this->domainname, $this->buf);

                // Get the domain name
                $this->domainname = array_pop($matches);

                // Get or create the Domain object
                $domainModel = Domain::firstOrCreate([
                    'domain' => $this->domainname,
                ]);

                // Set in_bitportal to true, because we imported/updated from BIT dns zone file
                if (! $domainModel->in_bitportal) {
                    $domainModel->in_bitportal = true;
                    $domainModel->save();
                }
            }

            $this->buf .= $line."\n";
        }
    }
    /**
     * add a generated zone to the list of zoneFiles
     * and update the DNSRecords table according to the zone file.
     */
    private function flushBuffer(&$zoneList)
    {
        if ($this->buf === null) {
        } else {
            $zone = Parser::parse($this->domainname, $this->buf);
            $zoneList[$this->domainname] = $zone;
            $this->updateDnsRecords($zone, $this->domainname);
            $this->clearLocalData();
        }
    }

    private function clearLocalData()
    {
        $this->buf = null;
        $this->domainname = null;
        $this->domainModel = null;
    }

    private function updateDnsRecords($zone, $domainname)
    {
        $dm = Domain::where('domain', '=', $domainname)->firstOrFail();
        $recordsToDelete = $dm->importedDnsRecords()->pluck('id')->toArray();

        foreach ($zone->getResourceRecords() as $record) {
            $ttl = ($record->getTtl() !== null) ? $record->getTtl() : 0;

            /**
             * if ($record->getType() == "SOA")
             * {
             * $rdata = '';
             * } elseif ($record->getType() == "A") {
             *
             * $rdata = $record->getRdata()->getAddress();
             * } else {
             * $rdata = '';
             * }
             */
            $rdata = $record->getRdata()->output();

            $result = $dm->dnsRecords()->updateOrCreate(
                // Define the unique fields to select the record
                [
                    'name' => $record->getName(),
                    'type' => $record->getType(),
                    'destination' => $rdata,

                ],
                // Dynamic data
                [
                    'comment' => $record->getComment(),
                    'ttl' => $ttl,
                    'imported_by_zonefile' => 1,
                ]
            );

            if ($result->wasRecentlyCreated) {
                Log::info('Created DNS record: '.$record->getName().'.'.$domainname);
            } else {
                // Remove id from toDelete Array
                $recordsToDelete = array_diff($recordsToDelete, [$result->id]);

                if (count($result->getChanges()) > 0) {
                    Log::info('Updated DNS record: '.$record->getName().'.'.$domainname);
                    Log::debug(print_r($result->getChanges(), true));
                }
            }
        }

        // Delete records removed from DNS
        if (count($recordsToDelete) > 0) {
            Log::debug('Deleting '.count($recordsToDelete).' records from domain: '.$domainname);
            // This is not working because an direct ->delete() doens't fire am delete event
            //DnsRecord::whereIn('id', $recordsToDelete)->delete();
            DnsRecord::whereIn('id', $recordsToDelete)->get()->each(function($obj) {
            	$obj->delete();
            });
        }
    }
}
