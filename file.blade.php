@extends('app.layout')
@section('content')
    
<div class="container">
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{Session::get('success')}}</strong> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{Session::get('error')}}</strong> 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
   @endif
    <div class="row">
        <form   enctype="multipart/form-data" method="post" action="{{route('file-upload-save')}}" >
                @csrf 
                <div class="mb-3">
                    <label for="formFile" class="form-label">Default file input example</label>
                    <input class="form-control" type="file" name="file" id="formFile">
                </div>
                @error('file')
                <p class="text-danger">{{$message}}</p>
                @enderror
                <button type="submit" class="btn btn-primary">Submit</button>
        </form>
</div>
@endsection