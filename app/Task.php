<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function user() 
    {
    	return $this->belongsTo(\App\User::class);
    }

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
    	'created_at',
    	'updated_at',
    	'deleted_at'
    ];
}
