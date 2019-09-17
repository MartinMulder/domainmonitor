<?php

namespace App\Models;

use App\Models\Ip;
use Illuminate\Database\Eloquent\Model;

class DnsRecord extends Model
{
    protected $fillable = ['name', 'type', 'destination', 'comment', 'ttl', 'imported_by_zonefile'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($dnsRecord) {
            if (filter_var($dnsRecord->destination, FILTER_VALIDATE_IP)) {
                $ip = Ip::firstOrCreate(['ip' => $dnsRecord->destination]);
                $dnsRecord->ip()->associate($ip);
            }
        });
    }

    public function ip()
    {
        return $this->belongsTo('App\Models\Ip');
    }

    public function canDelete()
    {
        return ! $this->imported_by_zonefile;
    }

    public function scopeImported($query)
    {
        return $query->where('imported_by_zonefile', '=', true);
    }

    public function domain()
    {
        return $this->belongsTo('App\Models\Domain');
    }
}
