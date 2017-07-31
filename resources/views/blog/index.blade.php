@extends('main')

@section('title','| Blog Posts')


@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Blog</h1>
		</div>
	</div>

	@foreach($posts as $post)

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<hr>
			<h2>{{$post->title}}</h2>
			<h5>Published: {{date('M j, Y',strtotime($post -> created_at))}}</h5>

			<p class="lead">{{substr(strip_tags($post->body),0,250)}}{{strlen(strip_tags($post->body)) > 250 ? '....' :''}}</p>

			<a href="{{ route('blog.single', $post->slug) }}" class="btn btn-primary">Read More</a>

		</div>
	</div>
	@endforeach

	<div class="row">
		<div class="col-md-12">
			<div class="text-center">
				{!! $posts->links() !!}
			</div>
		</div>
	</div>

@endsection