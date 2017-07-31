<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

use Mail;

use Session;


class PagesController extends Controller
{
	public function getIndex(){

		$posts = Post::orderBy('id','desc')->where('public',true)->limit(4)->get();

		return view('pages/welcome',compact('posts')); 

	}

	public function getAbout(){
		$first='Aminul';
		$last='Islam';
		$fullname= $first ." ". $last;
		$email='Email : Nullghost@gmail.com';

		return view('pages/about',compact('fullname','email'));

	}

	public function getContact(){

		return view('pages/contact');

	}

	public function postContact(Request $request){

		$this->validate($request, [ 
			'email' => 'required|email',
			'subject' => 'min:5',
			'message'=>'min:20'
			]);

		$data = array(
			'email' => $request->email,
			'subject'=> $request->subject,
			'bodyMessage' => $request->message 

			); 

		Mail::send('emails.contact',$data,function($message) use ($data){

			$message->from($data['email']);
			$message->to('nullghost13@gmail.com');
			$message->subject($data['subject']);


		});

		Session::flash('success','Your message is successfully Sent');

		return redirect()->route('contact.index');


	}

}