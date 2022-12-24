@extends('layouts.master')
@section('title','LogIn')
@section('content')
<div class="login-form">
    @if($errors)
    @foreach ($errors->all() as $error)
       <div class="text-danger">{{ $error }}</div>
   @endforeach
   @if(session('updateSuccess'))
   <div class="alert alert-success alert-dismissible fade show" role="alert">
     <i class="fa-solid fa-check"></i>   {{ session('updateSuccess')}}
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
 @endif
 @endif
    <form action="{{ route('login')}}" method="post">
        @csrf
        <div class="form-group">
            <label>Email Address</label>
            <input class="au-input au-input--full" type="email" name="email" placeholder="Email">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input class="au-input au-input--full position-relative" type="password" id="password" name="password" placeholder="Password">
            <span class="position-absolute mt-2 text-muted" id="togglePassword" style="margin-left: -30px;"><i class="fa-regular fa-eye"></i></span>
        </div>
                                
        <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
                                
    </form>
    <div class="register-link">
        <p>
            Don't you have account?
            <a href="{{ route('auth#registerPage') }}">Sign Up Here</a>
        </p>
    </div>
</div>
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function(){
            $password = $('#password');
            $('#togglePassword').click(function(){
                $type = $password.attr('type') == 'password' ? 'text' : 'password' ;
                $icon = $password.attr('type') == 'password' ? `<i class="fa-regular fa-eye-slash"></i>` : `<i class="fa-regular fa-eye"></i>`;
                $password.attr('type', $type );
                $('#togglePassword').html($icon);
            })
    })
    </script>
@endsection
