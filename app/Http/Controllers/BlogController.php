<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

class BlogController extends Controller
{
    public function getIndex(){

    	//fetch from the database and save it on variable
    	$posts = Post::orderBy('created_at','desc')->where('public',true)->paginate(5);


    	//return the view and pass in the post object
        return view('blog.index',compact('posts'));



    }

    public function getSingle($slug){
   
   		//fetch from the database based on slug

   		$post = Post::where('slug', '=', $slug)->first();

   		//return the view and pass in the post object
   		return view('blog.single',compact('post'));
   
    }


}
