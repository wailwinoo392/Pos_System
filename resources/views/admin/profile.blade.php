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
                <div class="p-5 bg-light">
                    <a class="text-dark" href="{{ route('admin#home')}}"><i class="fa-solid fa-arrow-left"></i></a>
                    <h3 class="text-center title-2">Edit Profile</h3>
                    <hr>
                    @if(session('notMatch'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                           {{ session('notMatch')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    @endif
                    @if(session('updateSuccess'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-check"></i>   {{ session('updateSuccess')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    @endif
                    <form action="{{ route('admin#update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-4 offset-2 mt-2">
                                @if(Auth::user()->gender == 'male' && Auth::user()->image == null )
                                <img src="{{ asset('image/male_user_default.jpeg')}}"/>
                                @elseif(Auth::user()->gender == 'female' && Auth::user()->image == null)
                                <img src="{{ asset('image/female_user_default.jpeg')}}"/>
                                @else
                                <img src="{{ asset('storage/'.Auth::user()->image)}}"/>
                                @endif
                                <input type="file" name="image" class="form-control my-3 @error('email') is-invalid @enderror"> 
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message}}
                                    </div>
                                @enderror
                                <div class="row my-3" >
                                    <button class="bg-primary btn btn-dark col-8 offset-2 "><i class="fa-solid fa-pen-to-square me-1"></i>Update Profile</button>
                                </div>
                            </div>
                                
                            <div class="col-5">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="cc-payment" class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="name" value="{{ old('name',Auth::user()->name)}}" type="phone" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Confirmpassword">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="cc-payment" class="control-label mb-1">Email</label>
                                        <input id="cc-pament" name="email" value="{{ old('email',Auth::user()->email)}}" type="email" class="form-control @error('email') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Name">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="cc-payment" class="control-label mb-1">Phone</label>
                                        <input id="cc-pament" name="phone" value="{{ old('phone',Auth::user()->phone)}}" type="number" class="form-control @error('phone') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Email">
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex">
                                        <div class="form-group col-6">
                                            <label for="cc-payment" class="control-label mb-1 ">Gender</label>
                                            <select name="gender" disabled class="form-control " id="">
                                                <option value="male" @if(Auth::user()->gender == 'male') selected @endif>Male</option>
                                                <option value="female" @if(Auth::user()->gender == 'female') selected @endif>Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group offset-1 col-5">
                                            <label for="cc-payment" class="control-label mb-1 ">Role</label>
                                            <select name="role" disabled class="form-control" id="">
                                                <option value="admin" @if(Auth::user()->role == 'admin') selected @endif>Admin</option>
                                                <option value="user" @if(Auth::user()->role == 'user') selected @endif>User</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="cc-payment" class="control-label mb-1">Address</label>
                                        <textarea id="cc-pament" name="address"  type="text" class="form-control @error('address') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Your Address">{{ old('address',Auth::user()->address)}}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="cc-payment" class="control-label mb-1">Password</label>
                                        <input id="cc-pament" name="password"  type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter Your Password">
                                        @error('password')
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
@endsection