<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZoneFile extends Model
{
    protected $fillable = ['title', 'source', 'content', 'imported'];
    public $trackChanges = ['title', 'content'];

    public function auditLogs()
    {
        return $this->morphMany('App\Models\AuditLog', 'auditable');
    }
}
