@extends('main')

@section('title','| All Categories')

@section('content')

	<div class="row">
		<div class="col-md-8">
			<h1>Categories</h1>
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>
					@foreach($categories as $category)
					<tr>
						<th>{{ $category->id }}</th>
						<td><a href="{{ route('categories.show',$category->id) }}" >{{ $category->name }}</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div><!--End of 8 column grid-->

        @if(Auth::guard('admin')->check())
		<div class="col-md-3">
			<div class="well">
				{!! Form::open(['route' => 'categories.store','method' => 'POST','data-parslley-validate' => '']) !!}

					<h2>New Category</h2>
					{{ Form::label('name','Name') }}
					{{ Form::text('name',null,['class' => 'form-control','required'=>'','maxlength' => '255']) }}
					{{ Form::submit('Create New Category',['class' => 'btn btn-primary btn-block btn-h1-spacing']) }}


				{!! Form::close() !!}
			</div>
		</div>
		@endif
	</div>

@endsection