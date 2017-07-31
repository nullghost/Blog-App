@extends('main')

@section('title',"| $category->name Tag")

@section('content')

	<div class="row">
		<div class="col-md-8">
			<h1>{{ $category->name }} Category <small>{{ $category->posts()->count() }} Posts</small></h1>
		</div>

		<!-- Used if condition to restrict from deleting the General category -->
		@if(Auth::guard('admin')->check())
		@if($category->name != 'General Post' )
		<div class="col-md-2">
			<a href="{{ route('categories.edit',$category->id) }}" class="btn btn-primary pull-right btn-block" style="margin-top:20px;">Edit</a>
		</div>
		<div class="col-md-2">
			
			{{ Form::open(['route' => ['categories.destroy',$category->id],'method' => 'DELETE']) }}
			
				{{ Form::submit('Delete',['class' => 'btn btn-danger btn-block btn-h1-spacing','style' => 'margin-top:20px;']) }}

			{{ Form::close() }}
			
		</div>
		@endif
		@endif
	</div>

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Title</th>
						<th>body</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($category->posts as $post)
						@if($post->public)
							<tr>
								<th> {{$post->id}} </th>
								<td> {{$post->title}} </td>
								<td>  {{ substr($post->body, 0,50) }} {{ strlen($post->body) > 50 ? "....":"" }}  </td>

								@if(Auth::guard('admin')->check())
								<td><a href="{{ route('posts.show',$post->id) }}"class="btn btn-default btn-sm">View</a></td>
								
								@else
								
								<td><a href="{{ route('blog.single',$post->slug) }}"class="btn btn-default btn-sm">View</a></td>
							    
							    @endif
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>
		</div>	
	</div>

	
	


@endsection