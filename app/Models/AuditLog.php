<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $fillable = ['action', 'result', 'user', 'description'];

    public function auditable()
    {
    	return $this->morphTo();
    }
}
