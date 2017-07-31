<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function post()
    {
    	return $this->belongsTo('App\Post');
    }
    // reply table connect
    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
}
