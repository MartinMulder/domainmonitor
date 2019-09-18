<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhoisData extends Model
{
    protected $fillable = [
        'domainname',
        'active',
        'dnsservers',
        'owner',
        'registrar',
        'creationDate',
        'expirationDate',
        'whoisserver',
        'rawData',
    ];

    public $tracKChanges = [
        'domainname',
        'active',
        'dnsservers',
        'owner',
        'registrar'
    ];

    protected $dates = ['creationDate', 'expirationDate'];

    public function auditLogs()
    {
        return $this->morphMany('App\Models\AuditLog', 'auditable');
    }
}
