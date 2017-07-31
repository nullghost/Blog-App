@extends('main')

@section('title','| Contact')

@section('content')

       <div class="row" style="margin-top:10px;">
          <div class="col-md-8 col-md-offset-2">
            <div class="well" style="background-color:rgba(245, 245, 245, 0);">
               <h1>Contact Us</h1>
               <hr>
               <form action="{{ route('contact.send') }}" method="POST">
                {{ csrf_field() }}
                   <div class="form-group">
                       <label name="email">Email</label>
                       <input id="email" type="" name="email" class="form-control" placeholder="Someone@example.com">
                   </div>
                   <div class="form-group">
                       <label name="subject">Subject</label>
                       <input id="subject" type="" name="subject" class="form-control">
                   </div>
                   <div class="form-group">
                       <label name="message">Message</label>
                       <textarea id="message" type="" name="message" class="form-control" placeholder="Type your message here..."></textarea>
                   </div>
                   <input type="submit" name="Send Message" value="Send Message" class="btn btn-success btn-block ">
                   
               </form>

           </div> 
          </div>   
       </div>
   
   @endsection