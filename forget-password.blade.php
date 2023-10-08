@extends('app.layout')
@section('content')
<main>
        <div class="mt-5">
            @if(Session::has('error'))
            <div class="alert alert-danger ">{{session::get('error')}}</div>
            @endif
            @if(Session::has('success'))
            <div class="alert alert-success ">{{session::get('success')}}</div>
            @endif
        </div>
          <p>We will send a link to your mail, use that link to reset password.</p>
    <form action="{{ route('forget.password.post') }}" method="POST" class="ms-auto me-auto mt-auto">
        @csrf 
        <div >
            <label for="email" class="form-label">Email address</label>
            <input type="email"  name="email" class="form-control" id="email" aria-describedby="emailHelp">
            @error('email')
            <div class="error text-danger">{{$message}}</div>
            @enderror
        </div>
    <button type="submit" class="btn btn-primary mt-3">Submit</button>

    </form>
</main>
@endsection