   

<nav class="navbar navbar-inverse navbar-fixed-top  " >
<div class="container-fluid">
<!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>
  <a class="navbar-brand" href="/"><span class="glyphicon glyphicon-home" style="color:#337ab7;width:20px;"></span> Laravel Blog</a>
</div>

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  <ul class="nav navbar-nav">
    <li class=" {{ Request::is('/') ? "active" : "" }} "><a href="/">Home</a></li>
    <li class=" {{ Request::is('blog') ? "active" : "" }} "><a href="/blog">Blog</a></li>
    <li class="{{ Request::is('about') ? "active" : "" }}"><a href="/about">About</a></li>
    <li class="{{ Request::is('contact') ? "active" : "" }}"><a href="/contact">Contact</a></li>
  </ul>


  @if (Auth::guest() && !Auth::guard('admin')->check())
     <ul class="nav navbar-nav navbar-right">
        <li><a href="{{ route('login') }}">Login</a></li>
        <li><a href="{{ route('register') }}">Register</a></li>
     </ul>
  @elseif((Auth::guard('admin')->check() && Auth::guard('web')->check())||Auth::guard('admin')->check())
      <ul class="nav navbar-nav navbar-right">
        <li class="navbar-profile-image"><img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim(Auth::guard('admin')->user()->email ))) . "?=50&d=retro" }} " class="author-image">
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::guard('admin')->user()->name }} <span class="caret"></span></a>
          <ul class="nav nav-navbar dropdown-menu">
            <li><a href="{{ route('posts.index') }}"><span class="glyphicon glyphicon-th-list"></span> Posts</a></li>
            <li><a href="{{ route('posts.draft') }}"><span class="glyphicon glyphicon-tasks"></span> Drafts</a></li>
            <li><a href="{{route('categories.index')}}"><span class="glyphicon glyphicon-list-alt" ></span> Categories</a></li>
            <li><a href="{{route('tags.index')}}"><span class="glyphicon glyphicon-tags"></span> Tags</a></li>
            <li role="separator" class="divider"></li>
            <li>
                  <a href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                     <span class="glyphicon glyphicon-off"></span>  Logout
                  </a>

                  <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>
            </li>
          </ul>
        </li>
      </ul>

     @elseif(Auth::guard('web')->check() )
      <ul class="nav navbar-nav navbar-right">
        <li class="navbar-profile-image"><img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim(Auth::guard('web')->user()->email ))) . "?=50&d=retro" }} " class="author-image">
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::guard('web')->user()->name }} <span class="caret"></span></a>
          <ul class="nav nav-navbar dropdown-menu">
            <li><a href="{{ route('posts.create') }}"><span class="glyphicon glyphicon-th-list"></span> Create Posts</a></li>
            <li><a href="{{route('categories.index')}}"><span class="glyphicon glyphicon-list-alt"></span> Categories</a></li>
            <li><a href="{{route('tags.index')}}"><span class="glyphicon glyphicon-tags"></span> Tags</a></li>
            <li role="separator" class="divider"></li>
            <li>
                  <a href="{{ route('user.logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                    <span class="glyphicon glyphicon-off"></span>  Logout
                  </a>

                  <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>
            </li>
          </ul>
        </li>
      </ul>
    @endif
</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>


<!--End Navbar-->