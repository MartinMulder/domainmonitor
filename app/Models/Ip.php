<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    protected $fillable = ['ip', 'reverse_dns', 'whois_data'];
    public $trackChanges = ['ip', 'reverse_dns', 'whois_data'];

    public function dnsRecords()
    {
        return $this->hasMany('App\Models\DnsRecord');
    }

    public function services()
    {
        return $this->hasMany('App\Models\Service');
    }

    public function auditLogs()
    {
    	return $this->morphMany('App\Models\AuditLog', 'auditable');
    }
}
