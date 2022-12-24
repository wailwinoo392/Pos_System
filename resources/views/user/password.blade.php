

@extends('user.layouts.master')
@section('title','Password Change')
@section('leftContent')
<div class="px-2 py-5">
    <h4>Password Validation Rule</h3>
    <ul class="mt-4">
        <li>English uppercase characters (A – Z)</li>
        <li>English lowercase characters (a – z)</li>
        <li>Base 10 digits (0 – 9)</li>
        <li>Non-alphanumeric (For example: !, $, #, or %)</li>
        <li>Unicode characters</li>
    </ul>
</div>
@endsection
@section('centerContent')
<div class="p-md-3">
    <a class="text-dark" href="{{ route('user#home')}}"><i class="fa-solid fa-arrow-left"></i></a>
    <h3 class="text-center title-2">Change Password</h3>
    <hr>
    @if(session('notMatch'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
           {{ session('notMatch')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    <form action="{{ route('user#passwordChange')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="offset-md-1 col-md-5 mt-2">
                @if(Auth::user()->gender == 'male' && Auth::user()->image == null )
                <img style="width: 100%;" src="{{ asset('image/male_user_default.jpeg')}}"/>
                @elseif(Auth::user()->gender == 'female' && Auth::user()->image == null)
                <img style="width: 100%;" src="{{ asset('image/female_user_default.jpeg')}}"/>
                @else
                <img style="width: 100%;" src="{{ asset('storage/'.Auth::user()->image)}}"/>
                @endif
                <div class="row my-3">
                    <div class="form-group col-6">
                        <label for="cc-payment" class="control-label mb-1 ">Gender</label>
                        <select disabled class="form-control " id="">
                            <option value="male" @if(Auth::user()->gender == 'male') selected @endif>Male</option>
                            <option value="female" @if(Auth::user()->gender == 'female') selected @endif>Female</option>
                        </select>
                    </div>
                    <div class="form-group col-6 ">
                        <label for="cc-payment" class="control-label mb-1 ">Role</label>
                        <select disabled class="form-control" id="">
                            <option value="admin" @if(Auth::user()->role == 'admin') selected @endif>Admin</option>
                            <option value="user" @if(Auth::user()->role == 'user') selected @endif>User</option>
                        </select>
                    </div>
                </div>
                <input disabled type="file" name="image" class="form-control mb-3">
                <div class="row my-3" >
                    <button class="bg-warning btn btn-dark col-8 offset-2 "><i class="fa-solid fa-key"></i>  Change Password</button>
                </div>
            </div>
                                
            <div class="col-md-5">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="cc-payment" class="control-label mb-1">Name</label>
                        <input disabled id="cc-pament" value="{{ old('name',Auth::user()->name)}}" type="phone" class="form-control" aria-required="true" aria-invalid="false" placeholder="Confirmpassword">
                    </div>
                    <div class="form-group col-12">
                        <label for="cc-payment" class="control-label mb-1">Email</label>
                        <input disabled id="cc-pament"  value="{{ old('email',Auth::user()->email)}}" type="email" class="form-control " aria-required="true" aria-invalid="false" placeholder="Enter Name">
                    </div>
                    <div class="form-group col-12">
                        <label for="cc-payment" class="control-label mb-1">Phone</label>
                        <input disabled id="cc-pament"  value="{{ old('phone',Auth::user()->phone)}}" type="number" class="form-control " aria-required="true" aria-invalid="false" placeholder="Enter Email">
                    </div>
                    <div class="form-group col-12">
                        <label for="cc-payment" class="control-label mb-1">Address</label>
                        <input disabled id="cc-pament" value="{{ old('address',Auth::user()->address)}}"  type="text" class="form-control " aria-required="true" aria-invalid="false" placeholder="Enter Your Address">
                    </div>
                    <div class="form-group col-12">
                        <input class="au-input au-input--full form-control position-relative" type="password" id="password" name="newPassword" placeholder="New Password">
                        <span class="position-absolute text-muted" id="togglePassword" style="margin-left: 85%; margin-top: -29px"><i class="fa-regular fa-eye"></i></span>
                        @error('newPassword')
                            <div class="text-danger">
                                {{ $message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-12">
                        <label for="cc-payment" class="control-label mb-1">ConfirmPassword</label>
                        <input class="au-input au-input--full form-control position-relative" type="password" id="password1" name="confirmPassword" placeholder="Comfirm Password">
                        <span class="position-absolute text-muted" id="togglePassword1" style="margin-left: 85%; margin-top: -29px"><i class="fa-regular fa-eye"></i></span>
                        @error('confirmPassword')
                            <div class="text-danger">
                                {{ $message}}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-12">
                        <label for="cc-payment" class="control-label mb-1">Old Password</label>
                        <input class="au-input au-input--full form-control position-relative " type="password" id="password2" name="oldPassword" placeholder="Old Password">
                        <span class="position-absolute text-muted" id="togglePassword2" style="margin-left: 85%; margin-top: -29px"><i class="fa-regular fa-eye"></i></span>
                        @error('oldPassword')
                            <div class="text-danger">
                                {{ $message}}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function(){
            $('#togglePassword').click(function(){
                $password = $('#password');
                $type = $password.attr('type') == 'password' ? 'text' : 'password' ;
                $icon = $password.attr('type') == 'password' ? `<i class="fa-regular fa-eye-slash"></i>` : `<i class="fa-regular fa-eye"></i>`;
                $password.attr('type', $type );
                $('#togglePassword').html($icon);
            })
        $('#togglePassword1').click(function(){
            $password = $('#password1');
            $type = $password.attr('type') == 'password' ? 'text' : 'password' ;
            $icon = $password.attr('type') == 'password' ? `<i class="fa-regular fa-eye-slash"></i>` : `<i class="fa-regular fa-eye"></i>`;
            $password.attr('type', $type );
            $('#togglePassword1').html($icon);
        })
        $('#togglePassword2').click(function(){
            $password = $('#password2');
            $type = $password.attr('type') == 'password' ? 'text' : 'password' ;
            $icon = $password.attr('type') == 'password' ? `<i class="fa-regular fa-eye-slash"></i>` : `<i class="fa-regular fa-eye"></i>`;
            $password.attr('type', $type );
            $('#togglePassword2').html($icon);
        })
    })
    </script>
@endsection