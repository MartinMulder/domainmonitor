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
    	'rawData'
    ];

	protected $dates = ['creationDate', 'expirationDate'];
}
