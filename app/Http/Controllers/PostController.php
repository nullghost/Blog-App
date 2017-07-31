<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Post;
use App\Category;
use App\Tag;
use App\Comment;

use Session;
use Purifier;
use Image;
use Storage;



class PostController extends Controller
{




 public function __construct() {

      
            $this->middleware('auth:admin')->except('create','store');
    }

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Create a variable and get all blog from database use paginate funtion to use page system
        $posts = Post::orderBy('created_at','desc')->where('public',true)->paginate(10);

        //return a view and pass in the above variable
        return view('posts.index',compact('posts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    if(Auth::guard('admin')->check()||Auth::guard('web')->check())
        {
            $categories = Category::all();

            $tags = Tag::all();

            return view('posts.create',compact('categories','tags'));
        }else{
            return redirect()->route('login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::guard('admin')->check()||Auth::guard('web')->check())
            {  
            //validate the data
            $this->validate($request, array(
                    'title'         => 'required|max:255',
                    'slug'          => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
                    'category_id'   => 'required|integer',
                    'body'          => 'required',
                    'featured_image'=> 'sometimes|image',
                ));

            //store in the database
            $post = new Post;

            $post->title = $request->title;
            $post->slug = $request->slug;
            $post->public = false;
            $post->category_id =$request->category_id;
            $post->body = Purifier::clean($request->body);


            //save image
            if($request->hasFile('featured_image')){

                $image = $request->file('featured_image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $location =public_path('images/' . $filename);
                Image::make($image)->resize(800,400)->save($location);

                $post->image =$filename;

            }
            

            $post->save();

            $post->tags()->sync($request->tags, false);

            //Set Success or Eroor Message
            Session::flash('success','The Blog post was successfully saved!'); 

            if (Auth::guard('admin')->check()) {
                // redirect to another page
            return redirect()->route('posts.show',$post->id);
            }else{
                return redirect()->route('posts.create');
            }

            
        }else{
            return redirect()->route('login');
        }
    }

    //publish a post

    public function publish($id){

        $post = Post::find($id);
        $post->public = true;
        $post->save();

        return redirect()->route('posts.draft');

    }

    //show draft page

    public function draft(){

        $posts = Post::orderBy('created_at','desc')->where('public',false)->paginate(10);
       

        return view('posts.draft',compact('posts'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $post = Post::find($id);

        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //find the post in the database and save it as a variable
        $post = Post::find($id);
        //categories
        $categories = Category::all();
        $cats = array();
        foreach ($categories as $category) {
            $cats[$category->id] = $category->name;
        }

        $tags = Tag::all();
        $tags2 = array();

        foreach ($tags as $tag) {
            $tags2[$tag->id] = $tag->name;
        }


        //return the view and pass in the variable 
        return view('posts/edit',compact('post'))->withCategories($cats)->withTags($tags2);
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
        //validate the data
        $post = Post::find($id);
        if ($request->input('slug') == $post->slug) {
            
            $this->validate($request, array(
                'title'=> 'required|max:255',
                'category_id'=>'required|integer',
                'body' => 'required',
                'featured_image'=>'image'
            ));


        }else{

            $this->validate($request, array(
                    'title'=> 'required|max:255',
                    'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
                    'category_id'=>'required|integer',
                    'body' => 'required',
                    'featured_image'=>'image'
                ));
        }

        //save the data to the database
        $post = Post::find($id);

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->public = $post->public;
        $post->category_id =$request->input('category_id');
        $post->body = Purifier::clean($request->input('body'));

        if($request->hasFile('featured_image')){

            //Add the new Photo
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location =public_path('images/' . $filename);
            Image::make($image)->resize(800,400)->save($location);

            $oldFilename = $post->image;

            //Update the database
            $post->image =$filename;

            //Delete the old photo
            Storage::delete($oldFilename);


        }

        $post->save();

        $post->tags()->sync($request->tags);

        //set flash data with success message
        Session::flash('success','This Post is successfully Updated');

        //redirect with flash data to post.show
        return redirect()->route('posts.show',$post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find the post in the database and delete it
        $post = Post::find($id);

        $comments = Comment::all()->where('post_id',$id);
        
        //disconnect the tags
        $post->tags()->detach();

        foreach ($comments as $comment) {

            $comment->delete();
        }


        Storage::delete($post->image);


        $post->delete();

        Session::flash('success','The Post is successfully Deleted !!!');

        //redirect

        return redirect()->route('posts.index');
    }
}
