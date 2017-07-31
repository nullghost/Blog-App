@extends('main')

<?php $titleTag = htmlspecialchars($post->title); ?>

@section('title',"| $titleTag")


@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">

			@if($post->image)
			<img src="{{ asset('images/'.$post->image) }}" height="400" width="750"  alt="Blog cover pic"/>
			
			@else
			<img src="{{ asset('images/default.jpeg') }}" height="400" width="750"  alt="Blog cover pic"/>
		    
		    @endif

			<h1>{{ $post->title }}</h1>
			<p> {!! $post->body !!} </p>
			<!-- now because two tables are connected we can get any information from any table -->
			<br/><br/>
			<p class="pull-bottom"><strong>Posted In: {{ $post->category->name }}</strong>, <small>{{$post -> updated_at->diffForHumans()}}</small> </p>
			
			<hr>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8 col-md-offset-2" style="border: 1px solid #ddd;">

			<h3 class="comments-title"><span class="glyphicon glyphicon-comment"></span> {{ $post->comments()->count() }} Comments</h3>


				@foreach($post->comments as $comment)

				<?php $id =$comment->id;?>

				<div class="comment well">

					<div class="author-info">
						<img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->email))) . "?=50&d=retro" }} " class="author-image">
						<div class="author-name">
							<h4>{{ $comment->name }}</h4>
							<p class="author-created_at">{{ date('F nS,Y - g:iA',strtotime($comment->created_at)) }}</p>
						</div>

					</div>

					<div class="comment-content">
						{{ $comment->comment }}
					</div>
						<div class="edit-delete-button">
							<div class="row">
								<div class="col-md-1">
							<button class="btn btn-primary btn-xs " type="button" data-toggle="collapse" data-target=".reply-comments-{{$comment->id}}" aria-expanded="false" aria-controls="reply-comments-{{$comment->id}}"><span class="glyphicon glyphicon-share-alt"></span> Reply </button>
								</div>
					 @if (Auth::check() && Auth::user()->email == $comment->email)
						

							
									

											<div class="col-md-1" style="margin-left:10px">
												<a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
											</div>

											<div class="col-md-1">
												{{ Form::open(['route' => ['comments.destroy',$comment->id],'method' => 'DELETE']) }}
			
												{{ Form::button(
													    '<span class="glyphicon glyphicon-trash"></span> Delete',
													    array(
													        'class'=>'btn btn-danger btn-xs',
													        'type'=>'submit')) 
												}}

												{{ Form::close() }}
											</div>
											<!--Delete SHOULD BE POST METHOD SO HAVE TO USE FORM-->
						@endif			
								<div class="col-md-3 reply-comments-{{$comment->id}} collapse in" style="margin-left:10px; margin-top:5px"> <small><span class="glyphicon glyphicon-comment"></span> {{$comment->replies()->count() }} Comment Replies</small></div>
								</div>
							
						
					
						    {{-- reply Div --}}	
							<div class="reply-comments-{{$comment->id}} collapse">

							<h4 class="comments-title" style="margin-top:30px;"><span class="glyphicon glyphicon-comment"></span> {{$comment->replies()->count() }} Comment Replies</h4>

							  @foreach($comment->replies as $comment)

							  <div class="well"  style="margin-top:20px">

							  	<div class="author-info">
									<img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->email))) . "?=50&d=retro" }} " class="author-image">
									<div class="author-name">
										<h4>{{ $comment->name }}</h4>
										<p class="author-created_at">{{ date('F nS,Y - g:iA',strtotime($comment->created_at)) }}</p>
									</div>

								</div>
								<div class="comment-content">
									{{ $comment->comment }}
								</div>
								<div class="edit-delete-button">
									
									 @if (Auth::check() && Auth::user()->email == $comment->email)
						

											
									<div class="row">

											<div class="col-md-1"><a href="{{ route('replies.edit', $comment->id) }}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span> Edit</a></div>

											<div class="col-md-1" style="margin-left:5px">
												{{ Form::open(['route' => ['replies.destroy',$comment->id],'method' => 'DELETE']) }}
			
												{{ Form::button(
													    '<span class="glyphicon glyphicon-trash"></span> Delete',
													    array(
													        'class'=>'btn btn-danger btn-xs',
													        'type'=>'submit')) 
												}}

												{{ Form::close() }}
											</div>
											<!--Delete SHOULD BE POST METHOD SO HAVE TO USE FORM-->
											
									</div>
											
										
									@endif

								</div>
							    
							  </div>
							  @endforeach
							   {!! Form::open(['route' => ['replies.store',$id],'method' => 'POST']) !!}

								<div class="row">
									<div class="col-md-6">
										
										{{ Form::label('name','Name:') }}
										{{ Form::text('name',null,['class' => 'form-control']) }}

									</div>

									<div class="col-md-6">
										
										{{ Form::label('email' , 'Email:') }}
										{{ Form::text('email',null,['class'=>'form-control','placeholder' => 'SomeOne@example.com']) }}

									</div>

									<div class="col-md-12">
										
										{{ Form::label('comment','Comment:') }}
										{{ Form::textarea('comment',null,['class'=>'form-control','rows'=>'3','placeholder' => 'Post a Reply....']) }}

										{{ Form::submit('Post Comment',['class'=>'btn btn-success btn-block btn-h1-spacing']) }}

									</div>

								</div>

							 {!! Form::close() !!}

							</div>
						</div>

				</div>


				@endforeach

		</div>
	</div>
	
	<div class="row">
		<div id="comment-form" class="col-md-8 col-md-offset-2" style=" margin-top: 70px;">
			 {{ Form::open(['route' => ['comments.store',$post->id],'method' => 'POST']) }}

				<div class="row">
					<div class="col-md-6">
						
						{{ Form::label('name','Name:') }}
						{{ Form::text('name',null,['class' => 'form-control']) }}

					</div>

					<div class="col-md-6">
						
						{{ Form::label('email' , 'Email:') }}
						{{ Form::text('email',null,['class'=>'form-control','placeholder' => 'SomeOne@example.com']) }}

					</div>

					<div class="col-md-12">
						
						{{ Form::label('comment','Comment:') }}
						{{ Form::textarea('comment',null,['class'=>'form-control','rows'=>'5','placeholder' => 'Post a Comment....']) }}

						{{ Form::submit('Post Comment',['class'=>'btn btn-success btn-block btn-h1-spacing']) }}

					</div>

				</div>

			 {{ Form::close() }}
		</div>
	</div>


@endsection