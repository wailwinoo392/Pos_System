@extends('admin.layouts.master')
@section('title','Profile')
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
                        <h2 class="title-1">Product Create Page</h2>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('admin#productCreated')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row col-8 offset-2 bg-light p-4">
                <a class="text-dark" href="{{ route('admin#productList')}}"><i class="fa-solid fa-arrow-left"></i></a>
                <div class="px-5 py-3">
                    <h3 class="mb-3">Create Product</h3>
                    <div class="mb-3 d-flex">
                        <div class="col-7">
                            <label for="" class="form-label">Product Name</label>
                            <input type="text" name="productName" value="{{ old('productName')}}" class="form-control @error('productName') is-invalid @enderror" placeholder="Enter Product Name">
                        </div>
                        <div class="offset-1">
                            <label for="" class="form-label">Product Price</label>
                            <input type="number" name="productPrice" value="{{ old('productPrice') }}" class="form-control @error('productPrice') is-invalid @enderror" placeholder="Enter Product Price" >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Product Description</label>
                        <textarea type="text" name="productDescription" class="form-control @error('productDescription') is-invalid @enderror" placeholder="Enter Product Description">{{ old('productDescription')}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Waiting Time</label>
                        <input type="number" name="waitingTime" class="form-control @error('waitingTime') is-invalid @enderror" value="{{ old('waitingTime')}}" placeholder="Minutes">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Category</label>
                        <select  name="categoryId" class="form-select" >
                            @foreach($data as $item)
                            <option @if(old('categoryId') == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Image</label>
                        <input type="file" name="productImage" class="form-control @error('productImage') is-invalid @enderror" >
                        @error('productImage')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary offset-4 col-4 mb-3 py-3 ">Create Product</button>
            </div>
        </form>
    </div>
</div>
@endsection
