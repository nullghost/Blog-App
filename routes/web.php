<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




//Authentication routes
//Route::get('auth/login','Auth\AuthController@getLogin');
//Route::post('auth/login','Auth\AuthController@postLogin');
//Route::get('auth/logout','Auth\AuthController@getLogout');

//Registration routes

//Route::get('auth/register','Auth\AuthController@getRegister');
//Route::post('auth/register','Auth\AuthController@postRegister');

// Categories 

Route::resource('categories','CategoryController',['except' => ['create']]);

//Comments
Route::post('comments/{post_id}',['uses' => 'CommentsController@store' ,'as' => 'comments.store']);
Route::get('comments/{id}/edit',['uses'=>'CommentsController@edit', 'as' => 'comments.edit']);
Route::put('comments/{id}',['uses'=>'CommentsController@update', 'as' => 'comments.update']);
Route::delete('comments/{id}',['uses'=>'CommentsController@destroy', 'as' => 'comments.destroy']);

//reply
Route::post('replies/{comment_id}',['uses' => 'ReplyController@store' ,'as' => 'replies.store']);
Route::get('replies/{id}/edit',['uses'=>'ReplyController@edit', 'as' => 'replies.edit']);
Route::put('replies/{id}',['uses'=>'ReplyController@update', 'as' => 'replies.update']);
Route::delete('replies/{id}',['uses'=>'ReplyController@destroy', 'as' => 'replies.destroy']);
Route::get('replies/{id}',['uses' => 'ReplyController@show','as'=>'replies.show']);



//Tags
Route::resource('tags','TagController',['except' => ['create']]);
//Blog routes
Route::get('blog/{slug}', ['as' => 'blog.single','uses' => 'BlogController@getSingle'])->where('slug', '[\w\d\-\_]+');

Route::get('blog', ['uses' => 'BlogController@getIndex','as' => 'blog.index']);

//admin routs
Route::prefix('admin')->group(function(){
 	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::post('/logout','Auth\AdminLoginController@logout')->name('admin.logout');
 });

//contact form

Route::get('contact',['uses'=>'PagesController@getContact', 'as' =>'contact.index']);

Route::post('contact',['uses'=>'PagesController@postContact', 'as' =>'contact.send']);

//About Page

Route::get('about', 'PagesController@getAbout');

//Home Page
Route::get('/', 'PagesController@getIndex');

//Posts
Route::get('posts/draft',['uses'=>'PostController@draft', 'as' =>'posts.draft']);
Route::get('posts/{id}/publish',['uses'=>'PostController@publish', 'as' =>'posts.publish']);

Route::resource('posts','PostController');









Auth::routes();
Route::post('/users/logout','Auth\LoginController@userLogout')->name('user.logout');