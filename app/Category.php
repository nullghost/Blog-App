<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    //connect to a table
    public function posts(){

    	return $this -> hasMany('App\Post');
    }
}
