
<!DOCTYPE html>
<html lang="en">
  <head>
    @include('partials/_head')
  </head>

  <body>

      @include('partials/_nav')

      <!-- Default bootstrap navbar-->
      <!--End Navbar-->

  
      <div class = "body" style="margin-top:60px">
        @include('partials/_messages')
        
      
          <div class="container" style="min-height:80vh">
          @yield('content')
          </div>
       @include('partials/_footer')
        

      </div> <!-- end of .container --> 

      @include('partials/_javascript')

      @yield('scripts')

  </body>


</html>