@extends('main')

@section('title',"| $tag->name Tag")

@section('content')

	<div class="row">
		<div class="col-md-8">
			<h1>{{ $tag->name }} Tag <small>{{ $tag->posts()->count() }} Posts</small></h1>
		</div>

		@if(Auth::guard('admin')->check())
		<div class="col-md-2">
			<a href="{{ route('tags.edit',$tag->id) }}" class="btn btn-primary pull-right btn-block" style="margin-top:20px;">Edit</a>
		</div>
		<div class="col-md-2">
			{{ Form::open(['route' => ['tags.destroy',$tag->id],'method' => 'DELETE']) }}
			
				{{ Form::submit('Delete',['class' => 'btn btn-danger btn-block btn-h1-spacing','style' => 'margin-top:20px;']) }}

			{{ Form::close() }}
		</div>
		@endif
	</div>

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Title</th>
						<th>Tags</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($tag->posts as $post)
						@if($post->public)
							<tr>
								<th> {{$post->id}} </th>
								<td> {{$post->title}} </td>
								<td> 
									@foreach($post->tags as $tag)

										<span class="label label-default">  {{ $tag->name }} </span>&nbsp;

									@endforeach
								</td>
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