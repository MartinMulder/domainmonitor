<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['port', 'protocol', 'state','service_name','product', 'version'];

    public function ip()
    {
        return $this->belongsTo('App\Models\Ip');
    }
}
