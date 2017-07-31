@extends('main')

@section('title','| Edit Comment Replies')

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
		<h3>Edit Comment</h3>

		{{ Form::model($reply,['route' => ['replies.update',$reply->id],'method' => 'PUT']) }}

			{{ Form::label('name','Name:') }}
			{{ Form::text('name',null,['class' => 'form-control','disabled' => '']) }}

			{{ Form::label('email','Email:') }}
			{{ Form::text('email',null,['class' =>'form-control','disabled'=>'']) }}

			{{ Form::label('comment','Comment:') }}
			{{ Form::textarea('comment',null,['class'=>'form-control']) }}

			{{ Form::submit('Update Comment',['class'=>'btn btn-success btn-block btn-h1-spacing']) }}

		{{ Form::close() }}
		</div>
	</div>

@endsection