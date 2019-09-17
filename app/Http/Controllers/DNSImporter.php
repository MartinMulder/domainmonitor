<?php

namespace App\Http\Controllers;

use App\Models\DnsRecord;
use App\Models\Domain;
use Badcow\DNS\Parser\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class DNSImporter extends Controller
{
    private $buf = null;
    private $domainname = null;

    public function import()
    {
        $zoneList = array();
        $domainModel = null;

    	//$zoneFile = '/tmp/dns_domains.txt';
    	//$data = file_get_contents($zoneFile);
    	$data = file('/tmp/dns_domains.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    	foreach ($data as $line)
    	{
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
                if (!$domainModel->in_bitportal) 
                {
                    $domainModel->in_bitportal = true;
                    $domainModel->save();
                }
    		} 

            $this->buf .= $line . "\n"; 
    	}
    	//$zone = Parser::parse('test.zone', $data);
//    	return view('dns/zone', compact('zone'));
        return view('dns/zoneList', compact('zoneList'));
    }

    // DO NOT CHANGE AFTER THIS LINE

    /**
     * add a generated zone to the list of zoneFiles
     * and update the DNSRecords table according to the zone file
     */
    private function flushBuffer(&$zoneList)
    {
        if ($this->buf === null)
        {
            //throw new \Exception('Empty buffer exception');
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
            

        Log::debug("start");
        foreach($zone->getResourceRecords() as $record)
        {
            $ttl = ($record->getTtl() !== null) ? $record->getTtl() : 0;

            /**
            if ($record->getType() == "SOA")
            {
                $rdata = '';
            } elseif ($record->getType() == "A") {

                $rdata = $record->getRdata()->getAddress();
            } else {
                $rdata = '';
            }
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
                    'imported_by_zonefile' => 1
                ]
            );

            if ($result->wasRecentlyCreated)
            {
                Log::info('Created DNS record: ' . $record->getName() . "." . $domainname);
            } else {
                // Remove id from toDelete Array
                $recordsToDelete = array_diff($recordsToDelete, [$result->id]);

                if (count($result->getChanges()) > 0)
                {
                    Log::info("Updated DNS record: " . $record->getName() . "." . $domainname);
                    Log::debug(print_r($result->getChanges(), true));    
                }
                
            }
        }

        // Delete records removed from DNS
        if (count($recordsToDelete) > 0) 
        {
            Log::debug('Deleting ' . count($recordsToDelete) . ' records from domain: ' . $domainname);    
            DnsRecord::whereIn('id', $recordsToDelete)->delete();
        }
        
        
    }

}
