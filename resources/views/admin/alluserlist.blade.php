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
                        <h2 class="title-1">Account List</h2>
    
                    </div>
                </div>
                <div class="table-data__tool-right">
                    <form action="{{route('admin#searchName')}}" method="post" class="d-flex">
                        @csrf
                        <input type="text" name="key" placeholder="Search Name" class="form-control float-left" id="">
                        <button class="btn btn-dark ms-2">
                            Search
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <form action="{{route('admin#userRole')}}" method="post" class="row">
            @csrf
            <div class="float-start col-3">
                <select name="role" class="form-control" id="">
                    <option @if(request('role') == "admin") selected @endif value="admin">Admin</option>
                    <option @if(request('role') == "user") selected @endif value="user">User</option>
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
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th></th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Last Updated</th>
                        <th>Message</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody id="dataList">
                    @foreach ($data as $item)
                    <tr class="tr-shadow">
                        <td class="col-1"><div class="image">
                            @if($item->gender == 'male' && $item->image == null )
                            <img class="img-thunbnails"src="{{ asset('image/male_user_default.jpeg')}}"/>
                            @elseif($item->gender == 'female' && $item->image == null)
                            <img class="img-thunbnails" src="{{ asset('image/female_user_default.jpeg')}}"/>
                            @else
                            <img class="img-thunbnails" src="{{ asset('storage/'.$item->image)}}"/>
                            @endif
                        </div></td>
                        <td class="col-1">{{ $item->name}}</td>
                        <td class="col-2">{{$item->email}}</td>
                        <td class="col-2">{{ $item->phone }}</td>
                        <td>{{ $item->gender }}</td>
                        <td class="col-2">{{ $item->updated_at->format('j-M-Y') }}</td>
                        <td>
                            @if($item->role != 'admin')
                            <a  href="{{route('admin#messageHistory',$item->id)}}">
                            <i class="fa-regular fa-comment-dots fs-5 text-muted "></i>
                            </a> 
                            @endif
                        </td>
                        <td class="col-2">
                            <input type="hidden" name="" id="userId" value="{{$item->id}}">
                            <select name="status" @if(Auth::user()->id == $item->id) disabled @endif class="form-control adminRoleChange" id="">
                                <option @if($item->role == 'admin') selected @endif value="admin">Admin</option>
                                <option @if($item->role == 'user') selected @endif value="user">User</option>
                            </select>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h3 class=" text-center mt-5">This is no Account Here</h3>
            @endif
        </div>
    </div>
</div>
@endsection
@section('scriptSources')
<script>
    $(document).ready(function(){
        $('.adminRoleChange').change(function(){
            $parentNote = $(this).parents('tr');
            $sources = {
                'userId' : $parentNote.find('#userId').val(),
                'role' : $parentNote.find('.adminRoleChange').val()
            }
            $parentNote.remove();
            $.ajax({
                type : 'get',
                url : '/adminn/ajax/changeRole',
                data : $sources,
                dataType : 'json'
            }) 
        })
    })
</script>
@endsection
