@extends('main')

@section('title','| Edit Tag')

@section('content')

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		
	   <div class="well">
		{{ Form::model($tag, ['route' => ['tags.update',$tag->id],'method'=>'PUT']) }}
			
			{{ Form::label('name',"Title:") }}
			{{ Form::text('name',null,['class' => 'form-control']) }}

			{{ Form::submit('Save Changes',['class'=>'btn btn-success btn-h1-spacing']) }}  
			
			<a href="{{ route('tags.show',$tag->id) }}" class="btn btn-danger btn-h1-spacing">Cancel</a>

		{{ Form::close() }} 

		</div>
	</div>
</div>


@endsection