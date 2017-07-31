<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use Session;

use Auth;

class TagController extends Controller
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
    if(Auth::guard('admin')->check()||Auth::guard('web')->check())
        {
        $tags = Tag::paginate(10);
        return view('tags.index',compact('tags'));
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
        $this->validate($request, array(
            'name' => 'required|max:255'
            ));
        $tag = new Tag;

        $tag->name = $request->name;

        $tag->save();

        Session::flash('success','New Tag Is Successfully Crested');

        return redirect()->route('tags.index');
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
        $tag =Tag::find($id);

        return view('tags.show',compact('tag'));
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
        $tag = Tag::find($id);

        return view('tags.edit',compact('tag'));
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
        $tag = Tag::find($id);

        $this->validate($request, ['name' => 'required|max:255']);


        $tag->name = $request->name;

        $tag->save();

        Session::flash('success','Tag is Successfully Saved');

        return redirect()->route('tags.show',$tag->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag =Tag::find($id);

        $tag->posts()->detach();

        $tag->delete();

        Session::flash('success','Tag is deleted Successfully');

        return redirect()->route('tags.index');
    }
}
