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
            @foreach ($data as $item)
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
            <div class="row col-8 offset-2 bg-light py-5 px-2 shadow-sm">
                <h3 class="text-center mb-1">User Info</h3>
                <small class="col-12 text-center mb-4 text-warning"><i class="fa-solid fa-triangle-exclamation"></i> Including Delivery Charge</small>
                <div class="col-2 offset-1">
                    <a href="#">
                        @if(Auth::user()->gender == 'male' && Auth::user()->image == null )
                        <img class="img-thunbnails" src="{{ asset('image/male_user_default.jpeg')}}"/>
                        @elseif(Auth::user()->gender == 'female' && Auth::user()->image == null)
                        <img class="img-thunbnails" src="{{ asset('image/female_user_default.jpeg')}}"/>
                        @else
                        <img class="img-thunbnails" src="{{ asset('storage/'.Auth::user()->image)}}"/>
                        @endif
                    </a>
                </div>
                <div class="col-4 offset-1">
                    <div class="col-md-12 fs-6 mb-1 fw-100"><i class="me-3 fa-solid fa-user"></i>{{$data[0]->user_name}}</div>
                    <div class="col-md-12 fs-6 mb-1 fw-100"><i class="me-3 fa-solid fa-envelope"></i>{{$data[0]->email}}</div>
                    <div class="col-md-12 fs-6 mb-1 fw-100"><i class="me-3 fa-solid fa-location-dot"></i>{{$data[0]->address}}</div>
                </div>
                <div class="col-4 col-4">
                    <div class="col-md-12 fs-6 mb-1 fw-100"><i class="me-3 fa-solid fa-phone"></i>{{$data[0]->phone}}</div>
                    <div class="col-md-12 fs-6 mb-1 fw-100"><i class="me-3 fa-solid fa-hand-holding-dollar"></i>{{$order->total_price}}</div>
                </div>
            </div>
        </div>
        
        <div class="table-responsive table-responsive-data2">
            @if(count($data))
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th></th>
                        <th>Order Code</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr class="tr-shadow">
                        <td class="col-1"><img src="{{ asset('storage/'.$item->product_image )}}" alt=""></td>
                        <td class="col-2">{{ $item->product_name}}</td>
                        <td class="col-1">{{$item->price}}</td>
                        <td class="col-2"><a href="#" class="text-dark"> {{ $item->order_code }}</a></td>
                        <td class="col-1">{{ $item->qty }}</td>
                        <td class="col-1">{{ $item->total }}</td>
                        <td class="col-2">{{ $item->created_at->format('j-M-Y') }}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h3 class=" text-center mt-5">This is no Orders Here</h3>
            @endif
        </div>
    </div>
</div>
@endsection
@section('scriptSources')
<script>
    $(document).ready(function(){
        $('.orderStatusSearch').change(function(){
            $parentNote = $(this).parents('tr');
            $sources = {
                'orderId' : $parentNote.find('#orderId').val(),
                'status' : $parentNote.find('.orderStatusSearch').val()
            }
            $parentNote.remove();
            $.ajax({
                type : 'get',
                url : '/adminn/ajax/change/orderStatus',
                data : $sources,
                dataType : 'json'
            })
            
        })
    })
</script>
@endsection
