@extends('main')

@section('title','| View Post')

@section('content')

<div class="row">
	<div class="col-md-8">

		
		@if($post->image)
		<img src="{{ asset('images/'.$post->image) }}" height="400" width="750"  style="border-radius: 2%;"/>
		
		@else
		<img src="{{ asset('images/upload.png') }}" height="400" width="750"  style="border-radius: 2%;"/>
	    
	    @endif


		<h1> {{ $post -> title }} </h1>

		<p class="lead"> {!! $post -> body !!} </p>

		<hr>

		<div class="tags">
		@foreach($post->tags as $tag)
			<span class="label label-default">{{ $tag->name }}</span>
		@endforeach
		</div>
		
		<!--Comments Back-end View-->

		<div id="backend-comments" style="margin-top: 50px;">
			
			<h3>Comments <small>{{ $post->comments()->count() }} total</small></h3>

			<table class="table">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Comment</th>
						<th width="100px"></th>
					</tr>
				</thead>

				<tbody>
					@foreach($post->comments as $comment)
						<tr>
							<td>{{ $comment->name }}</td>
							<td>{{ $comment->email }}</td>
							<td>{{ $comment->comment }}</td>
							<td >
								<div class="row">
								<div class="col-md-1">
								<a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
								</div>

								<!--Delete SHOULD BE POST METHOD SO HAVE TO USE FORM-->
								<div class="col-md-1">
								{{ Form::open(['route' => ['comments.destroy',$comment->id],'method' => 'DELETE']) }}
					
										{{ Form::button(
											    '<span class="glyphicon glyphicon-trash"></span>',
											    array(
											        'class'=>'btn btn-danger btn-xs',
											        'type'=>'submit')) 
										}}

								{{ Form::close() }}
								</div>
								{{-- comments replies button --}}
								<div class="col-md-1">
								<a href="{{ route('replies.show',$comment->id) }}" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-comment"></span></a>
								</div>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

		</div>


	</div>
	
	<div class="col-md-4">
		<div class="well">
			<dl class="dl-horizontal">
			<label>Url:</label>
			<p><a href="{{ route('blog.single', $post->slug)  }}"> {{route('blog.single', $post->slug)}}</a> </p>
			</dl>

			<dl class="dl-horizontal">
			<label>Category:</label>
			<p> {{ $post->category->name }} </p>
			</dl>

			<dl class="dl-horizontal">
			<label>Created At:</label>
			<p> {{ date('M j, Y h:ia',strtotime( $post -> created_at))}} </p>
			</dl>

			<dl class="dl-horizontal">
			<label>Last Updated At:</label>
			<p> {{ date('M j, Y h:ia',strtotime( $post -> updated_at))}} </p>
			</dl>

			<dl class="dl-horizontal">
			<label>Status:</label>
			@if($post->public == true)
			<p> <strong style="color:green">Published</strong> </p>
			@else
			<p> <strong style="color:orange">Not Published !!!</strong> <span style="color:lightblue">(go to draft to publish)</span> </p>
			@endif
			</dl>
			<hr>

			<div class="row">
				<div class="col-sm-6">
					{!! Html::linkRoute('posts.edit','Edit',array($post->id),array('class'=>'btn btn-primary btn-block')) !!}
				</div>
				<div class="col-sm-6">
					{!! Form::open(['route' => ['posts.destroy',$post -> id ] , 'method' => 'DELETE']) !!}

					{!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block']) !!}

					{!! Form::close() !!}
				</div>
			</div>

			<div class="row">

			<div class="col-md-12">

				{{ Html::linkRoute('posts.index','<< See All Posts',[],[ 'class'=>'btn btn-default btn-block btn-h1-spacing']) }}

			</div>
			<div class="col-md-12">

				{{ Html::linkRoute('posts.draft','<< See All Drafts',[],[ 'class'=>'btn btn-default btn-block btn-h1-spacing']) }}

			</div>
				
			</div>

		</div>
	</div>

</div>

@endsection