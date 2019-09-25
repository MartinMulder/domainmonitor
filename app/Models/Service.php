<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public function scopeHttp(Builder $query)
    {
        return $query->where('service_name', '=', 'http')->orWhere('service_name', '=', 'https')->orWhere('service_name', '=', 'ssl');
    }

    public function isHttp()
    {
        return (
                $this->service_name == "http" ||
                $this->service_name == "https" ||
                $this->service_name == "ssl"
            );
    }

    public function getScheme()
    {
        // Default to servicename, but many https services are detected as http
        $scheme = $this->service_name;

        // If portnumber contains 443 make it https
        if (strpos($this->port, '443') !== false) 
        {
            $scheme = 'https';
        }

        // If scheme is ssl make it https
        if ($this->service_name == "ssl")
        {
            $scheme = "https";
        }

        return $scheme;
    }
}
