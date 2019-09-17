<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    public $fillable = ['ip', 'reverse_dns', 'whois_data'];

    public function dnsRecords() 
    {
    	return $this->hasMany('App\Models\DnsRecord');
    }
}
