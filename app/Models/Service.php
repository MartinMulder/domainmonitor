<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['port', 'protocol', 'state','service_name','product', 'version'];
    public $trackChanges = ['state', 'service_name','product','version'];

    public function ip()
    {
        return $this->belongsTo('App\Models\Ip');
    }

    public function auditLogs()
    {
        return $this->morphMany('App\Models\AuditLog', 'auditable');
    }
}
