@extends('user.layouts.master')
@section('title','Profile')
@section('leftContent')
<div class="mt-5" >
    <h4 class="ms-md-3" id="list2">Most Popular</h4>
    <table class="table  table-hover text-center mb-0" id="dataTableList">
        <thead class="" id="list1">
            <tr>
                <th>Product Name</th>
                <th>Review</th>
                <th>Price</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody class="align-middle" id="list">
            @foreach($product as $item)
            <tr>
                <td class="align-middle" >{{ $item->name }}</td>
                <td class="align-middle" >{{ $item->review_count }}</td>
                <td class="align-middle" >{{ $item->price }} Kyats</td>
                <td class="align-middle" ><a class="btn btn-outline-dark btn-square" href="{{ route('user#productDetail',$item->id)}}"><i class="fa-solid fa-info"></i></a></td>
            </tr>
            @endforeach
        </tbody>
        {{ $product->appends(request()->query())->links()}}
    </table>
</div>
@endsection
@section('centerContent')
<div class="p-md-3">
    <a class="text-dark" href="{{ route('user#home')}}"><i class="fa-solid fa-arrow-left"></i></a>
    @if(session('notMatch'))
      <div class="alert alert-danger col-6 offset-3 alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-check"></i>   {{ session('notMatch')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if(session('updateSuccess'))
      <div class="alert alert-success col-6 offset-3 alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-check"></i>   {{ session('updateSuccess')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    <h3 class="text-center title-2">Edit Profile</h3>
    <hr>
    <form action="{{ route('user#update')}}" method="post" enctype="multipart/form-data">
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
                <input type="file" name="image" class="form-control my-3 col-10 offset-1 @error('email') is-invalid @enderror"> 
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message}}
                    </div>
                @enderror
                <div class="row my-3" >
                    <button class="bg-warning btn btn-dark col-8 offset-2 "><i class="fa-solid fa-pen-to-square me-1"></i>Update Profile</button>
                </div>
            </div>
                                
            <div class="col-md-5 offset-md-1">
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
                        <input class="au-input au-input--full position-relative form-control" type="password" id="password" name="password" placeholder="Password">
                        <span class="position-absolute text-muted" id="togglePassword" style="margin-left: 370px; margin-top: -29px"><i class="fa-regular fa-eye"></i></span>
                        @error('password')
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