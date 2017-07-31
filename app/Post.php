<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	//connect with a table category
    public function category()
    {
    	return $this->belongsto('App\Category');
    }
    // connect with a table tags
    public function tags()
    {
    	return $this->belongsToMany('App\Tag');
    }
    // commets table connect
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
