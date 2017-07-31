<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reply;
use App\Post;
use App\Comment;

use Session;
use Auth;

class ReplyController extends Controller
{
    
    public function __construct(){

      
        $this->middleware('auth:admin',['except'=>['store','destroy','edit','update']]);

       
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $comment_id)
    {
        $this->validate($request, array(

            'name'   =>  'required|max:255',
            'email'  =>  'required|email|max:255',
            'comment'=>  'required|min:1|max:2000'

            ));

        $comment = Comment::find($comment_id);

        $id=$comment->post_id;

        $post = Post::find($id);

        $reply = new Reply();

        $reply->name = $request->name;
        $reply->email = $request->email;
        $reply->comment = $request->comment;
        $reply->approved = true;
        $reply->comment_id = $comment_id;
        $reply->comment()->associate($comment);

        $reply->save();

        Session::flash('success','Comment is Posted');

        return redirect()->route('blog.single',$post->slug);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::find($id);

        return view('replies.show',compact('comment'));
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
        $reply = Reply::find($id);
        return view('replies.edit',compact('reply'));
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
        $reply = Reply::find($id);

        $comment_id=$reply->comment_id;

        $comment = Comment::find($comment_id);

        $id=$comment->post_id;

        $post = Post::find($id);


        //$post = Post::find($id);

        $this->validate($request, array(

            'comment'=>  'required|min:1|max:2000',

            ));

        $reply->comment = $request->comment;

        $reply->save();

       Session::flash('success','The comment is successfully updated');

        if(Auth::guard('admin')->check()){

            return redirect()->route('replies.show',$comment_id);
        }else{

        return redirect()->route('blog.single',$post->slug);
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
        
        $reply = Reply::find($id);

        $comment_id=$reply->comment_id;

        $comment = Comment::find($comment_id);

        $id=$comment->post_id;

        $post = Post::find($id);



        $reply->delete();

        Session::flash('success','Comment Deleted');

        return redirect()->back();
    }
}
