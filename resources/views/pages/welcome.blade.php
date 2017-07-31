@extends('main')

@section('title','| Homepage')

@section('content')

        <div class="head">

          <div class="row" >
              <div class="col-md-12">
                  <div class="jumbotron"  style="margin-top:30px;background:url({{ asset('images/default.jpeg') }});background-repeat: no-repeat;background-size: cover; height:600px;">
                      <div class="row">
                      <div class="col-md-8 col-md-offset-2" style="background-color:rgba(8, 8, 8, 0.4); border-radius:30px; color:white; margin-top:120px">
                          <h1>Welcome to My Blog</h1>
                          <p class="lead">Thank you for visiting.This is my test website built with laravel.Please read my post's!</p>
                          <p><a class="btn btn-primary btn-lg" href="#" role="button">Popular Post</a>
                            <a class="btn btn-success btn-lg pull-right" href="{{ route('posts.create') }}" role="button" style="padding-left:30px;padding-right:30px;">Create New Post</a>
                          </p>
                          <p></p>
                      </div>
                      </div>
                  </div>
              </div>
          </div><!-- end of raw -->

        </div>

        <div class="row navbar-header">

           
            <div class="col-sm-8 col-md-8" >

                @foreach($posts as $post)
                    <div class="row jumbotron" >
                        <div class="col-md-3">
                            @if($post->image)
                            <img src="{{ asset('images/'.$post->image) }}" height="150"  alt="Blog cover pic" style="width:100%; margin-top:20px"/>
                            
                            @else
                            <img src="{{ asset('images/default.jpeg') }}" height="150" alt="Blog cover pic" style="width:100%; margin-top:20px" />
                            
                            @endif
                        </div>
                        <div class="post col-md-9">
                            <h3> {{$post->title}} </h3>
                            <h5><strong>Published:</strong> {{$post->updated_at->diffForHumans()}}</h5>
                            <p class="lead"> {{ substr(strip_tags($post->body), 0 ,300) }}{{ strlen(strip_tags($post->body)) > 300 ? "...." : ""}} </p>
                            <a href="{{ url('blog/'.$post -> slug) }}" class="btn btn-primary">Read More</a>
                        </div>
                    </div>

                   

                @endforeach

            </div>
            

            <div class="col-sm-3 col-md-3 col-md-offset-1" style="background-color:gray;border-radius:10px" >
                <h2>Sidebar</h2>
                <hr>
                 
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Collapsible Group Item #1
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                  </div>
                </div>
              </div>
              <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Collapsible Group Item #2
                    </a>
                  </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                  <div class="panel-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                  </div>
                </div>
              </div>
              <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingThree">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Collapsible Group Item #3
                    </a>
                  </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
                  </div>
                </div>
              </div>
            </div>

            <div class="embed-responsive embed-responsive-16by9" style="margin-bottom:20px">
              <iframe class="embed-responsive-item" src="//www.youtube.com/embed/6Qf_pVRjadE?rel=0"></iframe>
            </div>
            <div class="embed-responsive embed-responsive-16by9" style="margin-bottom:20px">
              <iframe class="embed-responsive-item" src="//www.youtube.com/embed/R8B4og-BeCk?rel=0"></iframe>
            </div>

            </div>
        </div>
 @endsection

