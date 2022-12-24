@extends('layouts.master')
@section('title','Register')
@section('content')
<div class="login-form">
    @if($errors)
       @foreach ($errors->all() as $error)
          <div class="text-danger">{{ $error }}</div>
      @endforeach
    @endif
    <form action="{{ route('register')}}" method="POST">
        @csrf
        <div class="row">
            <div class="form-group col-6">
                <label>Username</label>
                <input class="au-input au-input--full" type="text" name="name" placeholder="Username">
            </div>
            <div class="form-group col-6">
                <label>Email Address</label>
                <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input class="au-input au-input--full" type="password" name="password_confirmation" placeholder="Confirm Password">
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input class="au-input au-input--full" type="number" name="phone" placeholder="Phone">
        </div>
        <div class="form-group">
            <select name="gender" class="form-control" id="">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <div class="form-group">
            <label>Address</label>
            <input class="au-input au-input--full" type="text" name="address" placeholder="Address">
        </div>
                                
        <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">register</button>
                                
    </form>
    <div class="register-link">
        <p>
            Already have account?
            <a href="{{ route('auth#logInPage')}}">Sign In</a>
        </p>
    </div>
</div>
@endsection