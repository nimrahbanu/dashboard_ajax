@extends('app.layout')
@section('title','Registration')
@section('content')<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet"> 
<div class="container">
    <div class="mt-5">
    @if(Session::has('error'))
        <div class="alert alert-danger ">{{session::get('error')}}</div>
        @endif
        @if(Session::has('success'))
        <div class="alert alert-success ">{{session::get('success')}}</div>
        @endif
  
<form class="ms-auto me-auto mt-3" method="POST" action="{{ route('registrationPost') }}" style="width:500px" >
  @csrf 
    <div>
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" id="name" >
         @error('name')
         <div class="error text-danger">{{$message}}</div>
        @enderror
    </div>
    <div >
        <label for="email" class="form-label">Email address</label>
        <input type="email"  name="email" class="form-control" id="email" aria-describedby="emailHelp">
        @error('email')
        <div class="error text-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password"  name="password"  class="form-control" id="password">
        @error('password')
        <div class="error text-danger">{{$message}}</div>
        @enderror
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>
</div>
@endsection

