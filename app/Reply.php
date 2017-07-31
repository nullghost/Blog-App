<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table = 'replies';

    public function comment()
    {
    	return $this->belongsTo('App\Comment');
    }
}
