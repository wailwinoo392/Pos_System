@extends('admin.layouts.master')
@section('title','Message')
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
                <div class="col-8">
                    <div class="p-3">
                        <h3 class="text-center title-2">Message To {{$keys[$id]->name}}</h3>
                        <hr>
                    </div>
                    <div class="mx-3">
                        <form action="{{route('admin#createMessage')}}" method="post">
                          @csrf
                          <ul class="list-unstyled">
                            <li class="mb-3"><small>{{ $messageList->appends(request()->query())->links()}}</small></li>
                            @if(count($messageList))
                            @foreach($messageList->reverse() as $item)
                              @if($item->admin_id == Auth::user()->id)
                              <li class="d-flex justify-content-between adminDeleted">
                                <div class="card w-100 ms-5">
                                  <div class="card-header d-flex justify-content-between">
                                    <p class="fw-bold">{{ Auth::user()->name }}</p>
                                    <p class="text-muted small">{{ $item->created_at->diffForHumans() }}</p>
                                  </div>
                                  <div class="card-body deleteAlert">
                                    <p class="mb-0  " id="deleteAlert">
                                      {{ $item->message }}
                                    </p>
                                    <small class="text-muted float-end">
                                      <input type="hidden" name="messageId" id="messageId" value="{{$item->id}}">
                                      <input type="hidden" name="message" value="{{$item->message}}" id="message">
                                      <input type="hidden" id="adminMessageEdit" name="" value="Edit">
                                        <a href="#" onclick="return false;" class=" text-muted adminMessageEdit">@if($item->created_at == $item->updated_at) Edit @else Edited @endif </a>
                                        <a href="#" onclick="return false;" class="text-muted adminMessageDelete" >Delete</a>
                                    </small>
                                  </div>
                                </div>
                                  @if(Auth::user()->gender == 'male' && Auth::user()->image == null )
                                  <img class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60" src="{{ asset('image/male_user_default.jpeg')}}"/>
                                  @elseif(Auth::user()->gender == 'female' && Auth::user()->image == null)
                                  <img class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60"  src="{{ asset('image/female_user_default.jpeg')}}"/>
                                  @else
                                  <img class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60"  src="{{ asset('storage/'.Auth::user()->image)}}"/>
                                  @endif
                              </li>
                              @elseif($item->admin_id != null)
                              <li class="d-flex justify-content-between">
                                @if($keys[$item->admin_id]->gender == 'male' && $keys[$item->admin_id]->image == null )
                                  <img class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="50" src="{{ asset('image/male_user_default.jpeg')}}"/>
                                  @elseif($keys[$item->admin_id]->gender == 'female' && $keys[$item->admin_id]->image == null)
                                  <img class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="50"  src="{{ asset('image/female_user_default.jpeg')}}"/>
                                  @else
                                  <img class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" style="width: 50px;height: 50px;"  src="{{ asset('storage/'.$keys[$item->admin_id]->image)}}"/>
                                  @endif
                                <div class="card w-100 me-5 ">
                                  <div class="card-header d-flex justify-content-between">
                                    <p class="fw-bold mb-0">{{ $keys[$item->admin_id]->name }}</p>
                                    <p class="text-muted small mb-0">{{ $item->created_at->diffForHumans() }}</p>
                                  </div>
                                  <div class="card-body">
                                    <p class="mb-0">
                                        {{ $item->message }}
                                    </p>
                                    <small class="text-muted float-end">
                                      <p class="me-1 text-muted"  >@if($item->created_at == $item->updated_at) @else Edited @endif </p>
                                  </small>
                                  </div>
                                </div>
                              </li>
                              @elseif($item->admin_id == null)
                              <li class="d-flex justify-content-between">
                                 @if($item->gender == 'male' && $item->image == null )
                                  <img class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="50" src="{{ asset('image/male_user_default.jpeg')}}"/>
                                  @elseif($item->gender == 'female' && $item->image == null)
                                  <img class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="50"  src="{{ asset('image/female_user_default.jpeg')}}"/>
                                  @else
                                  <img class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" style="width: 50px;height: 50px;"  src="{{ asset('storage/'.$item->image)}}"/>
                                  @endif
                                <div class="card w-100 me-5">
                                  <div class="card-header d-flex justify-content-between">
                                    <p class="fw-bold mb-0">{{ $item->user_name }}</p>
                                    <p class="text-muted small mb-0">{{ $item->created_at->diffForHumans() }}</p>
                                  </div>
                                  <div class="card-body">
                                    <p class="mb-0">
                                        {{ $item->message }}
                                    </p>
                                    <small class="text-muted float-end">
                                      <p class="me-1 text-muted"  >@if($item->created_at == $item->updated_at) @else Edited @endif </p>
                                  </small>
                                  </div>
                                </div>
                              </li>
                              @endif
                              <input type="hidden" name="userId" id="" value="{{$item->user_id}}">
                            @endforeach
                            @else
                            <input type="hidden" name="userId" id="" value="{{$id}}">
                            <input type="hidden" name="message" value="{{$id}}" id="message">
                            <h3 class=" text-center my-5">This is no Message</h3>
                            @endif
                            <li class=" mb-3 px-5" id="messageEditField">
                              <div class="form-outline">
                                <textarea class="form-control bg-white" id="oldText" placeholder="Enter Message" id="textAreaExample2" name="contactMessage" rows="4" required></textarea>
                                <label class="form-label" for="textAreaExample2">Message</label>
                              </div>
                              <button type="submit" class="btn btn-dark btn-rounded float-end">Send</button>
                            </li>
                          </ul>
                        </form>
                    </div>
                </div>
                <div class="col-4 bg-light p-3 ">
                    <h5 class="text-center">Message List</h3>
                    <ul class="list-unstyled navbar__list js-scrollbar1">
                        @foreach($unreadList as $item)
                        <li>
                            <div class="notifi__item">
                                <div class="bg-c1 img-cir img-40">
                                    @if($item->gender == 'male' && $item->image == null )
                                    <img class="img-thunbnails rounded-circle"src="{{ asset('image/male_user_default.jpeg')}}"/>
                                    @elseif($item->gender == 'female' && $item->image == null)
                                    <img class="img-thunbnails rounded-circle" src="{{ asset('image/female_user_default.jpeg')}}"/>
                                    @else
                                    <img class="img-thunbnails rounded-circle" src="{{ asset('storage/'.$item->image)}}"/>
                                    @endif
                                </div>
                                <a href="{{route('admin#messageHistory',$item->user_id)}}" class="content text-decoration-none">
                                    <div class="d-flex align-items-center justify-content-between text-dark">
                                        <label class="" for="price-all">{{$item->user_name}}</label>
                                        
                                        <span class="date">{{$item->updated_at->diffForHumans()}}</span>
                                    </div>
                                    <span class="date">{{$item->unread_message }}</span>
                                </a>
                            </div>
                        </li>
                        @endforeach
                        <div class="notifi__footer">
                          <a href="{{route('admin#allMessage')}}">all message</a>
                      </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scriptSources')
    <script>
        $(document).ready(function(){
           $('.adminMessageDelete').click(function(){
            $parentNote = $(this).parents('li');
            $messageId = { 'messageId' : $parentNote.find('#messageId').val()};
            $parentNote.find('.deleteAlert').html('<i class="fa-regular fa-trash-can"></i> Message Deleted');
            $.ajax({
              type : 'get',
              url : '/adminn/ajax/message/delete',
              data : $messageId,
              dataType : 'json',
            })
           })
           $('.adminMessageEdit').click(function(){
            $parentNote = $(this).parents('li');
            $messageId =  $parentNote.find('#messageId').val();
            $message = $parentNote.find('#message').val();
            $c = $parentNote.find('#adminMessageEdit').val();
            $d = $('#editmessageId').val();
            $a = `
            <div class="form-outline">
              <input type="hidden" name="editmessageId" id="editmessageId" value="${$messageId}">
              <textarea class="form-control bg-white" id="oldText" placeholder="Enter Message" id="textAreaExample2" name="contactMessage" rows="4" required>${$message}</textarea>
              <label class="form-label" for="textAreaExample2">Message</label>
            </div>
            <button type="submit" class="btn btn-dark btn-rounded float-end">Updated</button>
            `;
            $b = `
            <div class="form-outline">
              <textarea class="form-control bg-white" id="oldText" placeholder="Enter Message" id="textAreaExample2" name="contactMessage" rows="4" required></textarea>
              <label class="form-label" for="textAreaExample2">Message</label>
            </div>
            <button type="submit" class="btn btn-dark btn-rounded float-end">Send</button>
            `;
            if($c = 'Edit'){
              $('#messageEditField').html($a);
              $parentNote.find('.adminMessageEdit').html('Cancel');
            }
            if($d != null ){
              $('#messageEditField').html($b);
              $parentNote.find('.adminMessageEdit').html($c);
            }
            
           })
        })
    </script>
@endsection