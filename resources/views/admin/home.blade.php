@extends('admin.layouts.master')
@section('title','Admin Home')
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
<div class="main-content mt-3">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1 mb-5">overview</h2>
                    </div>
                </div>
            </div>
            <div class="row m-t-25">
                <div class="col-sm-6 col-lg-4">
                    <div class="overview-item overview-item--c1">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>
                                <div class="text">
                                    <h2>{{$orderCount}}</h2>
                                    <span>Order</span>
                                </div>
                            </div>
                            <div class="overview-chart">
                                <canvas id="widgetChart1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="overview-item overview-item--c2">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <div class="text">
                                    <h2>{{$customerCount}}</h2>
                                    <span>User</span>
                                </div>
                            </div>
                            <div class="overview-chart">
                                <canvas id="widgetChart2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="overview-item overview-item--c4">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="fa-solid fa-industry"></i>
                                </div>
                                <div class="text">
                                    <h2>{{$productCount}}</h2>
                                    <span>Product</span>
                                </div>
                            </div>
                            <div class="overview-chart">
                                <canvas id="widgetChart4"></canvas>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection