@extends('main')

@section('title','| Comment Replies')

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">


			<div class="comment well">

					<div class="author-info">
						<img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->email))) . "?=50&d=retro" }} " class="author-image">
						<div class="author-name">
							<h4>{{ $comment->name }}</h4>
							<h5>{{ $comment->email }}</h5>
							<p class="author-created_at">{{ date('F nS,Y - g:iA',strtotime($comment->created_at)) }}</p>
						</div>

					</div>

					<div class="comment-content">
						{{ $comment->comment }}
					</div>
						<div class="edit-delete-button">
						
								
							<a href="{{ route('posts.show', $comment->post_id) }}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-hand-left"></span> Go Back</a>

							<a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
								
						
						    {{-- reply Div --}}	
							<div >

							<h4 class="comments-title" style="margin-top:30px;"><span class="glyphicon glyphicon-comment"></span> {{$comment->replies()->count() }} Comment Replies</h4>

							  @foreach($comment->replies as $comment)

							  <div class="well"  style="margin-top:20px">

							  	<div class="author-info">
									<img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->email))) . "?=50&d=retro" }} " class="author-image">
									<div class="author-name">
										<h4>{{ $comment->name }}</h4>
										<h5>{{ $comment->email }}</h5>
										<p class="author-created_at">{{ date('F nS,Y - g:iA',strtotime($comment->created_at)) }}</p>
									</div>

								</div>
								<div class="comment-content">
									{{ $comment->comment }}
								</div>
								<div class="edit-delete-button">

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
				

								</div>
							    
							  </div>
							  @endforeach
							 
							</div>
						</div>

				</div>

		
		</div>
	</div>

@endsection