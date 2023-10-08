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
    <form action="{{ route('reset.password.post') }}" method="POST" class="ms-auto me-auto mt-auto">
        @csrf 
        <input type="text" hidden value="{{ !empty($token)? $token: ''}}" name="token">
        <div >
            <label for="email" class="form-label">Email address</label>
            <input type="email"  name="email" class="form-control" id="email" aria-describedby="emailHelp">
            @error('email')
            <div class="error text-danger">{{$message}}</div>
            @enderror
        </div>
        <div >
            <label for="password" class="form-label">Enter new password </label>
            <input type="password"  name="password" class="form-control" id="password"  >
            @error('password')
            <div class="error text-danger">{{$message}}</div>
            @enderror
        </div>
        <div >
            <label for="password_confirmation" class="form-label">Confirm password_confirmation</label>
            <input type="password"  name="password_confirmation" class="form-control" id="password_confirmation"   >
            @error('password_confirmation')
            <div class="error text-danger">{{$message}}</div>
            @enderror
        </div>
    <button type="submit" class="btn btn-primary mt-3">Submit</button>

    </form>
</main>
@endsection