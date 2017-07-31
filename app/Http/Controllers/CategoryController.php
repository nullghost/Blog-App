<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\Post;
use Session;

use Auth;

class CategoryController extends Controller
{
   

   public function __construct(){


        $this->middleware('auth:admin')->except('index','show');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // display a view of all of categories
        //it also have a form to create a new category

    if(Auth::guard('admin')->check()||Auth::guard('web')->check())
        {
        $categories = Category::all();

        return view('categories.index',compact('categories'));
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
        // Save a new category and redirect back to index page
        $this->validate($request, array(
            'name' => 'required|max:255'
            ));
        $category = new Category;

        $category->name = $request->name;

        $category->save();

        Session::flash('success','New Category has been created');

        return redirect()->route('categories.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    if(Auth::guard('admin')->check()||Auth::guard('web')->check())
        {
        $category =Category::find($id);

        return view('categories.show',compact('category'));
        }else{
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category =Category::find($id);

        return view('categories.edit',compact('category'));
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
        $category = Category::find($id);

        $this->validate($request, ['name' => 'required|max:255']);


        $category->name = $request->name;

        $category->save();

        Session::flash('success','Category is Successfully Saved');

        return redirect()->route('categories.show',$category->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category =Category::find($id);

        $posts =Post::all();
     //Because of deleting an existing category now we have to assign a new general category to those posts  
    //which were connected to this deleted  category


        foreach ($posts as $post) {
           if($post->category_id == $id){

            $post->category_id = 20;

            $post->save();

           } 
        }
        
        //delete category 
        $category->delete();



        Session::flash('success','Tag is deleted Successfully');

        return redirect()->route('categories.index');
    }
}
