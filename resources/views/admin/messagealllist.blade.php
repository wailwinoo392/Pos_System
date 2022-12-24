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
            <div class="offset-1 col-md-10 bg-light py-5 px-3">
                <h3 class="text-center">Message List</h3>
                    <ul class="list-unstyled navbar__list js-scrollbar1">
                        @if(count($unreadList))
                        @foreach($unreadList as $item)
                        <li class="mb-2 shadow-sm">
                            <div class="notifi__item position-relative">
                                <div class="bg-c1 img-cir img-40">
                                    @if($item->gender == 'male' && $item->image == null )
                                    <img class="img-thunbnails rounded-circle"src="{{ asset('image/male_user_default.jpeg')}}"/>
                                    @elseif($item->gender == 'female' && $item->image == null)
                                    <img class="img-thunbnails rounded-circle" src="{{ asset('image/female_user_default.jpeg')}}"/>
                                    @else
                                    <img class="img-thunbnails rounded-circle" src="{{ asset('storage/'.$item->image)}}"/>
                                    @endif
                                </div>
                                <a href="{{route('admin#messageHistory',$item->user_id)}}" class=" content text-decoration-none">
                                    <div class="d-flex align-items-center justify-content-between text-dark">
                                        <label class="" for="price-all">{{$item->user_name}}</label>
                                            
                                        <span class="date">{{$item->updated_at->diffForHumans()}}</span>
                                    </div>
                                    <span class="date">{{$item->unread_message }}</span>
                                </a>
                                <span class="position-absolute me-0" style="left: 95%; top: 60%"><a class="text-muted float-end" href="{{route('admin#messageDelete',$item->user_id)}}"><i class="fa-solid fa-trash-can"></i></a></span>
                            </div>
                        </li>
                        @endforeach
                        <li class="mb-3">{{ $unreadList->appends(request()->query())->links()}}</li>
                        @else
                        <h3 class=" text-center my-5">This is no Message Here</h3>
                        @endif
                    </ul>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scriptSource')
<script>
    $(document).ready(function(){
     
    })
</script>
@endsection
