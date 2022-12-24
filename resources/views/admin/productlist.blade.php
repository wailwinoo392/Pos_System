@extends('admin.layouts.master')
@section('title','Profile')
@section('header')
<h2 class="co-6 offset-3">Admin Dashboard Pannel</h2>
@endsection
@section('message')
<div class="noti-wrap">
    <div class="noti__item js-item-menu">
        <i class="fa-regular fa-envelope"></i>
        <span class="quantity">{{ $unreadCountTotal}}</span>
        <div class="notifi-dropdown js-dropdown">
            <div class="notifi__title">
                <p>We Have {{ $unreadCountTotal}} Unread Messsage</p>
            </div>
            @foreach ($unreadMessageList as $item)
            <div class="notifi__item">
                <div class="bg-c1 img-cir img-40">
                    <i class="fa-regular fa-envelope"></i>
                </div>
                <a href="{{route('admin#messageList',$item->user_id)}}" class="content text-decoration-none">
                    <div class="d-flex align-items-center justify-content-between text-dark">
                        <label class="" for="price-all">{{$item->user_name}}<span class="badge border font-weight-normal text-dark ms-2">{{$item->unread_count}}</span></label>
                        <span class="date">{{$item->updated_at->diffForHumans()}}</span>
                    </div>
                    <span class="date">{{$item->unread_message}}</span>
                </a>
            </div>
            @endforeach
            <div class="notifi__footer">
                <a href="{{route('admin#allMessage')}}">all message</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="row mb-2">
            <div class="table-data__tool">
                <div class="table-data__tool-left">
                    <div class="overview-wrap">
                        <h2 class="title-1">Product List</h2>
    
                    </div>
                </div>
                <div class="table-data__tool-right">
                    <a href="{{ route('admin#productCreatePage')}}">
                        <button id="add-category" class=" btn btn-outline-dark " >
                            <i class="zmdi zmdi-plus me-2"></i>Add Product
                        </button>
                    </a>
                </div>
            </div>
        </div>
        @if(session('categoryDuplicate'))
           <div class="alert alert-danger alert-dismissible fade show " role="alert">
             <i class="fa-solid fa-check"></i>   {{ session('categoryDuplicate')}}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>
         @endif
         @if(session('categoryDeleteSuccess'))
         <div class="alert alert-success alert-dismissible fade show " role="alert">
           <i class="fa-solid fa-check"></i>   {{ session('categoryDeleteSuccess')}}
           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
       @endif
       @if(session('categoryCreate'))
       <div class="alert alert-success alert-dismissible fade show " role="alert">
         <i class="fa-solid fa-check"></i>   {{ session('categoryCreate')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>
     @endif
        <div class="table-responsive table-responsive-data2">
            
            @if(count($data))
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th></th>
                        <th>Category Name</th>
                        <th>View Count</th>
                        <th>Price</th>
                        <th>Updated</th>
                        <th>Waiting Time</th>
                        <th>Review</th>
                    </tr>
                </thead>
                @foreach ($data as $item)
                <tbody>
                    <tr class="tr-shadow">
                        <input type="hidden" value="{{ $item->id}}" id="categoryId">
                        <input type="hidden" value="{{ $item->name}}" id="categoryName">
                        <td class="col-1"><img src="{{ asset('storage/'.$item->image) }}" alt=""></td>
                        <td class="col-1">{{ $item->name }}</td>
                        <td class="">{{ $item->category_id }}</td>
                        <td><i class="fa-regular fa-eye"></i> {{ $item->view_count }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->updated_at->format('j-M-Y') }}</td>
                        <td>{{ $item->waiting_time }} Minutes</td>
                        <td>{{ $item->review_count }}</td>
                        <td>
                            <div class="table-data-feature">
                                <a href="{{ route('admin#productUpdatePage',$item->id)}}"><button class="item me-1 category-edit" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="zmdi zmdi-edit "></i>
                                </button></a>
                                <a href="{{ route('admin#productDeleted',$item->id) }}">
                                    <button class="item " data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="zmdi zmdi-delete"></i>
                                    </button>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
            @else
            <h3 class=" text-center mt-5">This is no Categories Here</h3>
            @endif
            {{ $data->appends(request()->query())->links()}}</li>
        </div>
    </div>
</div>
@endsection
