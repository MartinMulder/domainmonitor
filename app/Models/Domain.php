<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = ['domain', 'in_bitportal', 'last_whois_date'];
    protected $dates = ['last_whois_date'];

    public $trackChanges = ['domain', 'in_bitportal'];

    public function whoisData()
    {
        return $this->hasOne('App\Models\WhoisData');
    }

    public function dnsRecords()
    {
        return $this->hasMany('App\Models\DnsRecord');
    }

    public function importedDnsRecords()
    {
        return $this->hasMany('App\Models\DnsRecord')->imported();
    }

    public function auditLogs()
    {
        return $this->morphMany('App\Models\AuditLog', 'auditable');
    }
}
