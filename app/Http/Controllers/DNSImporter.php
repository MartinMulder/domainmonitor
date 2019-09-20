<?php

namespace App\Http\Controllers;

use App\Models\DnsRecord;
use App\Models\Domain;
use Badcow\DNS\Parser\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Psy\Exception\DeprecatedException;

class DNSImporter extends Controller
{
    
    private $buf = null;
    private $domainname = null;

    public function import()
    {
        throw new DeprecatedException('DNS import should be done by: /zonefile/create');   
    }
}
