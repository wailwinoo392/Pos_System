

@extends('admin.layouts.master')
@section('title','Profile')
@section('header')
<h2 class="co-6 offset-3">Admin Dashboard Pannel</h2>
@endsection
@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card p-md-3">
                    <div class="card-body">
                        <div class="card-title">
                            <a class="text-dark" href="{{ route('admin#home')}}"><i class="fa-solid fa-arrow-left"></i></a>
                            <h3 class="text-center title-2">Change Password</h3>
                        </div>
                        <hr>
                        @if(session('notMatch'))
                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                               {{ session('notMatch')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                        @endif
                        <form action="{{ route('admin#passwordChange')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4 offset-2 mt-2">
                                    @if(Auth::user()->gender == 'male' && Auth::user()->image == null )
                                    <img class="img-thunbnails" src="{{ asset('image/male_user_default.jpeg')}}"/>
                                    @elseif(Auth::user()->gender == 'female' && Auth::user()->image == null)
                                    <img class="img-thunbnails" src="{{ asset('image/female_user_default.jpeg')}}"/>
                                    @else
                                    <img class="img-thunbnails" src="{{ asset('storage/'.Auth::user()->image)}}"/>
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
                                        <button class="bg-primary btn btn-dark col-8 offset-2 "><i class="fa-solid fa-key"></i>  Change Password</button>
                                    </div>
                                </div>
                                
                                <div class="col-5">
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
                                            <label for="cc-payment" class="control-label mb-1">New Password</label>
                                            <input id="cc-pament" name="newPassword"  type="password" class="form-control @error('newPassword') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="New Password">
                                            @error('newPassword')
                                                <div class="invalid-feedback">
                                                    {{ $message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="cc-payment" class="control-label mb-1">ConfirmPassword</label>
                                            <input id="cc-pament" name="confirmPassword"  type="password" class="form-control @error('confirmPassword') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Confirm Password">
                                            @error('confirmPassword')
                                                <div class="invalid-feedback">
                                                    {{ $message}}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="cc-payment" class="control-label mb-1">Old Password</label>
                                            <input id="cc-pament" name="oldPassword"  type="password" class="form-control @error('oldPassword') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Old Password">
                                            @error('oldPassword')
                                                <div class="invalid-feedback">
                                                    {{ $message}}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection