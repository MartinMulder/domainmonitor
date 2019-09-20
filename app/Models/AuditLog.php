<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $fillable = ['action', 'result', 'user', 'description'];

    protected static function boot()
    {
    	parent::boot();

    	static::addGLobalScope('order', function(Builder $builder) {
    		$builder->orderBy('id', 'desc');
    	});
    }

    public function auditable()
    {
    	return $this->morphTo();
    }
}
