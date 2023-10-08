@extends('app.layout')
@section('title', 'Home Page')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" />


    <div class="">
        @if(Session::has('error'))
        <div class="alert alert-danger ">{{session::get('error')}}</div>
        @endif
        @if(Session::has('success'))
        <div class="alert alert-success ">{{session::get('success')}}</div>
        @endif
    </div>
    <h2>welcome</h2>
   <a href="/first-mail" class="px-4 py-4 bg-indigo-500 hover:bg-indigo-700">send first mail</a> 
   <a href="/second-mail" class="px-4 py-4 bg-indigo-500 hover:bg-indigo-700">send second mail</a> 
@endsection