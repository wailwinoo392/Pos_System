@extends('admin.layouts.master')
@section('title','Product Edit')
@section('header')
<h2 class="co-6 offset-3">Admin Dashboard Pannel</h2>
@endsection
@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="row mb-3">
            <div class="table-data__tool">
                <div class="table-data__tool-left">
                    <div class="overview-wrap">
                        <h2 class="title-1">Product Edit Page</h2>
                    </div>
                </div>
            </div>
        </div>
        <form class="row col-10 offset-1 bg-light py-3" action="{{ route('admin#productUpdated')}}" method="post" enctype="multipart/form-data">
            @csrf
            <a class="text-dark" href="{{ route('admin#productList')}}"><i class="fa-solid fa-arrow-left"></i></a>
            <h3 class="my-5 text-center">Edit Your Product</h3>
            <div class="col-6">
                <div class="offset-2">
                    <div class="">
                        <img src="{{ asset('storage/'.$data->image )}} " class="img-thumbnails mb-3" alt="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Image</label>
                        <input type="file" name="productImage" class="form-control @error('productImage') is-invalid @enderror" >
                        @error('productImage')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="">
                    <div class="mb-3 d-flex">
                        <div class="col-7">
                            <label for="" class="form-label">Product Name</label>
                            <input type="text" name="productName" value="{{ old('productName',$data->name)}}" class="form-control @error('productName') is-invalid @enderror" placeholder="Enter Product Name">
                            @error('productName')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="offset-1">
                            <label for="" class="form-label">Product Price</label>
                            <input type="number" name="productPrice" value="{{ old('productPrice',$data->price) }}" class="form-control @error('productPrice') is-invalid @enderror" placeholder="Enter Product Price" >
                            <input type="hidden" name="productId" value="{{ $data->id }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Product Description</label>
                        <textarea type="text" name="productDescription" class="form-control @error('productDescription') is-invalid @enderror" placeholder="Enter Product Description">{{ old('productDescription',$data->description)}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Category</label>
                        <select  name="categoryId" class="form-select" >
                            @foreach($category as $item)
                            <option @if($data->category_id == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Waiting Time</label>
                        <input type="text" value="{{ old('waitingTime',$data->waiting_time )}}" name="waitingTime" class="form-control @error('waitingTime') is-invalid @enderror" placeholder="Minutes">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-outline-dark offset-4 col-4 mt-3 py-3">Updated Product</button>
        </form>
        <div class="row col-10 offset-1 bg-light p-5 mt-3" >
            <div class="bg-light p-30 mb-4">
                <div class="p-5">
                    <div class="">
                        <h4 class="mb-4">{{ count($review) }} review for {{ $data->name}}</h4>
                        @foreach($review as $item)
                        <div class="media mb-3 row shadow-sm">
                            <div class="col-1">
                                @if($item->gender == 'male' && $item->user_image == null )
                                <img class="img-fluid mr-3 mt-1" style="width: 45px;" src="{{ asset('image/male_user_default.jpeg')}}"/>
                                @elseif($item->gender == 'female' && $item->user_image == null)
                                <img class="img-fluid mr-3 mt-1" style="width: 45px;"  src="{{ asset('image/female_user_default.jpeg')}}"/>
                                @else
                                <img class="img-fluid mr-3 mt-1" style="width: 45px;"  src="{{ asset('storage/'.$item->user_image)}}"/>
                                @endif
                            </div>
                            <div class="media-body col-11">
                                <span>
                                    <div class="d-flex justify-content-between ">
                                        <h6><a href="{{route('admin#messageHistory',$item->user_id)}}" class="text-dark">{{$item->user_name}}</a></h6><small> <i>{{ $item->updated_at->diffForHumans()}} </i></small>
                                    </div>
                                    <p >{{$item->review }}</p>
                                    <div class="float-end mb-3 ">
                                        <input type="hidden" class="reviewId" name="reviewId" id="reviewId" value="{{ $item->id}}" >
                                        <a href="#" onclick="return false;" class="text-dark reviewDelete @if(Auth::user()->role == 'admin')  @elseif(Auth::user()->id != $item->user_id) d-none @endif">Delete</a>
                                    </div>
                                </span>
                            </div>
                        </div>
                        @endforeach
                        {{ $review->appends(request()->query())->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="row px-xl-5">
        <div class="">
            
        </div>
    </div>
</div>
@endsection
