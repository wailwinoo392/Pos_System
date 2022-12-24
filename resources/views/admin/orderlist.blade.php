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
        <div class="row mb-3">
            <div class="table-data__tool">
                <div class="table-data__tool-left">
                    <div class="overview-wrap">
                        <h2 class="title-1">Order List</h2>
    
                    </div>
                </div>
                <div class="table-data__tool-right">
                </div>
            </div>
        </div>
        <form action="{{route('admin#orderStatus')}}" method="post" class="row">
            @csrf
            <div class="float-start col-2">
                <select name="orderStatusSearch" class="form-control" id="">
                    {{-- <option selected value="">All</option> --}}
                    <option @if(request('orderStatusSearch') == "0") selected @endif value="0">Pending </option>
                    <option @if(request('orderStatusSearch') == "1") selected @endif value="1">Success</option>
                    <option @if(request('orderStatusSearch') == "2") selected @endif value="2">Reject</option>
                </select>
            </div>
            <button class="btn btn-dark col-1">
                Search
            </button>
        </form>
        <div class="table-responsive table-responsive-data2">
            @if(count($data))
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th></th>
                        <th>Order Code</th>
                        <th>Total Price</th>
                        <th>Order Date</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr class="tr-shadow">
                        <input type="hidden" value="{{ $item->id}}" id="orderId">
                        <td class="col-1">{{ $item->user_name}}</td>
                        <td class="col-1">{{$item->user_email}}</td>
                        <td class="col-2"><a href="{{route('user#orderDetail',$item->order_code)}}" class="text-dark"> {{ $item->order_code }}</a></td>
                        <td class="col-1">{{ $item->total_price }}</td>
                        <td class="col-1">{{ $item->created_at->format('j-M-Y') }}</td>
                        <td class="col-2">
                            <select name="status" class="form-control orderStatusSearch" id="">
                                <option @if($item->status == 0) selected @endif value="0">Pending </option>
                                <option @if($item->status == 1) selected @endif value="1">Success</option>
                                <option @if($item->status == 2) selected @endif value="2">Reject</option>
                            </select>
                        </td>
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
