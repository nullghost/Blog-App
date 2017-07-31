<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;
use App\Post;

use Session;

use Auth;

class CommentsController extends Controller
{
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {
        $this->validate($request, array(

            'name'   =>  'required|max:255',
            'email'  =>  'required|email|max:255',
            'comment'=>  'required|min:5|max:2000'

            ));

        $post = Post::find($post_id);

        $comment = new Comment();

        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = $request->comment;
        $comment->approved = true;
        $comment->post()->associate($post);

        $comment->save();

        Session::flash('success','Comment is Posted');

        return redirect()->route('blog.single',$post->slug);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       if(Auth::guard('admin')->check()||Auth::guard('web')->check())
        { 
        $comment = Comment::find($id);
        return view('comments.edit',compact('comment'));
        }else{
            return redirect()->route('login');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

        $this->validate($request, array(

            'comment'=>  'required|min:5|max:2000',

            ));

        $comment->comment = $request->comment;

        $comment->save();

        Session::flash('success','The comment is successfully updated');


        if(Auth::guard('admin')->check()){

            return redirect()->route('posts.show',$comment->post_id);
        }else{

        return redirect()->route('blog.single',$comment->post->slug);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $post_id = $comment->post->slug;
        $comment->delete();

        Session::flash('success','Comment Deleted');

        return redirect()->back();
    }
}
