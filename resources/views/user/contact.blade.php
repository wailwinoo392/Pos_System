@extends('user.layouts.master')
@section('title','Message')
@section('content')
<div class="row">
  <div class="col-md-3 bg-light shadow-sm py-5" >
    <h5 class="ms-3" id="list2">Most Popular</h4>
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
    </table>
</div>
    <div class="col-md-9">
        <div class="mx-1 bg-light p-md-5 shadow-sm ">
          <div class="p-3">
            <h3 class="text-center title-2">Message To Admin Team</h3>
            <hr>
          </div>
            <form action="{{route('user#createMessage')}}" class="" method="post">
              @csrf
              <ul class="list-unstyled">
                <li class="mb-3">{{ $data->appends(request()->query())->links()}}</li>
                @foreach($data->reverse() as $item)
                @if($item->admin_id != null )
                  <li class="d-flex justify-content-between mb-2">
                    @if($item->gender == 'male' && $item->image == null )
                    <img class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" style="width: 50px; height: 50px;" src="{{ asset('image/male_user_default.jpeg')}}"/>
                    @elseif($item->gender == 'female' && $item->image == null)
                    <img class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" style="width: 50px; height: 50px;"  src="{{ asset('image/female_user_default.jpeg')}}"/>
                    @else
                    <img class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" style="width: 50px; height: 50px;"  src="{{ asset('storage/'.$item->image)}}"/>
                    @endif
                    <div class="card w-100 me-md-5">
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
                @if($item->admin_id == null)
                <li class="d-flex justify-content-between mb-2 deleteAlert">
                  <div class="card w-100 ms-md-5">
                    <div class="card-header d-flex justify-content-between">
                      <p class="fw-bold mb-0">{{ Auth::user()->name }}</p>
                      <p class="text-muted small mb-0">{{ $item->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="card-body deleteAlert">
                      <p class="mb-0">
                        {{ $item->message }}
                      </p>
                      <small class="text-muted float-end">
                        <input type="hidden" id="messageId" value="{{$item->id}}">
                        <input type="hidden" name="message" value="{{$item->message}}" id="messagee">
                        <input type="hidden" name="" id="adminMessageEdit" value="Edit">
                          <a class="me-1 text-muted adminMessageEdit"  href="#" onclick="return false;">@if($item->created_at == $item->updated_at) Edit @else Edited @endif </a>
                          <a class="text-muted adminMessageDelete"  href="#" onclick="return false;" >Delete</a>
                      </small>
                    </div>
                  </div>
                    @if(Auth::user()->gender == 'male' && Auth::user()->image == null )
                    <img class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" style="width: 50px; height: 50px;" src="{{ asset('image/male_user_default.jpeg')}}"/>
                    @elseif(Auth::user()->gender == 'female' && Auth::user()->image == null)
                    <img class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" style="width: 50px; height: 50px;"  src="{{ asset('image/female_user_default.jpeg')}}"/>
                    @else
                    <img class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" style="width: 50px; height: 50px;"  src="{{ asset('storage/'.Auth::user()->image)}}"/>
                    @endif
                </li>
                @endif
                @endforeach
                <li class=" mb-3" id="messageEditField">
                  <div class="form-outline px-md-5 mt-4" >
                    <textarea class="form-control bg-white" id="textAreaExample2" name="contactMessage" rows="4" required></textarea>
                    <label class="form-label" for="textAreaExample2">Message</label>
                    <button type="submit" class="btn btn-warning btn-rounded float-end mt-3">Send</button>
                  </div>
                </li>
              </ul>
            </form>
        </div>
    </div>
</div>

@endsection
@section('scriptSource')
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
            $message = $parentNote.find('#messagee').val();
            $c = $parentNote.find('#adminMessageEdit').val();
            $d = $('#editmessageId').val();
            $a = `
            <div class="form-outline px-5 mt-4" >
              <input type="hidden" name="editMessageId" id="editmessageId" value="${$messageId}">
              <textarea class="form-control bg-white" id="textAreaExample2" name="contactMessage" rows="4" required>${$message}</textarea>
              <label class="form-label" for="textAreaExample2">Message</label>
              <button type="submit" class="btn btn-warning btn-rounded float-end mt-3">Update</button>
            </div>
            `;
            $b = `
            <div class="form-outline px-5 mt-4" >
              <textarea class="form-control bg-white" id="textAreaExample2" name="contactMessage" rows="4" required></textarea>
              <label class="form-label" for="textAreaExample2">Message</label>
              <button type="submit" class="btn btn-warning btn-rounded float-end mt-3">Send</button>
            </div>
            `;
            if($c == 'Edit'){
              $('#messageEditField').html($a);
              $parentNote.find('.adminMessageEdit').html('Cancel');
            }
            if($d != null ){
              $('#messageEditField').html($b);
              $parentNote.find('.adminMessageEdit').html('Edit');
            }
            
           })
        })
    </script>
@endsection