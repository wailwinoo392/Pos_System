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
                        <h2 class="title-1">Category List</h2>
    
                    </div>
                </div>
                <div class="table-data__tool-right">
                    <button class="btn btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2" >
                        <i class="zmdi zmdi-plus me-2"></i>Add Category
                    </button>
                    
                    <button class="btn btn-outline-dark ">
                        CSV download
                    </button>
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
            <div class="row">
                <div class="col">
                  <div class="collapse multi-collapse" id="multiCollapseExample1">
                    <div class="card card-body">
                        <form class="mt-5 my-5 bg-light col-6 offset-3"  action="{{route('admin#categoryCreated')}}" method="post">
                            <div class="row">
                                <button type="button" class="btn-close offset-11 mt-3 " data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2" aria-label="Close"></button>
                            </div>
                            @csrf
                            <div class="col-8 offset-2 bg-light py-2">
                                <h3 >Add Your Category</h3>
                                <label for="" class="form-label">Category Name</label>
                                <input type="text" name="category" class="form-control" required>
                                <button class="btn btn-dark my-3" type="submit">Create</button>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
              </div>
            @if(count($data))
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th class="col-4 text-center" >Name</th></th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                @foreach ($data as $item)
                <tbody>
                    <tr class="tr-shadow">
                        <input type="hidden" value="{{ $item->id}}" id="categoryId">
                        <input type="hidden" value="{{ $item->name}}" id="categoryName">
                        <td>{{ $item->id }}</td>
                        <td class="col-4 text-center">
                            {{ $item->name }}
                        </td>
                        <td class="">{{ $item->created_at->format('j-M-Y') }}</td>
                        <td>{{ $item->updated_at->format('j-M-Y') }}</td>
                        <td>
                            <div class="table-data-feature">
                                <button class="item me-3 category-edit" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="zmdi zmdi-edit "></i>
                                </button>
                                <a href="{{ route('admin#categoryDelete',$item->id) }}">
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
@section('scriptSources')
    <script>
        $(document).ready(function(){
            $('.category-edit').click(function(){
                $parentNote = $(this).parents('tr');
                $id = $parentNote.find('#categoryId').val();
                $name = $parentNote.find('#categoryName').val();
                $create = `
                <form class="mt-5"  action="{{route('admin#categoryUpdated')}}" method="post">
                    @csrf
                    <div class="col-6 offset-3 bg-light p-3">
                        <a class="text-dark" href="{{ route('admin#categoryList')}}"><i class="fa-solid fa-arrow-left"></i></a>
                        <button type="button" class=" offset-11 mt-3 " ></button>
                        <div class="p-5">
                            <h3>Edit Your Category</h3>
                            <label for="" class="form-label">Category Name</label>
                            <input type="text" name="category" class="form-control" value="${$name}" required>
                            <input type="hidden" name="categoryId" value="${$id}" id="categoryId">
                            <button class="btn btn-dark mt-3" type="submit">Create</button>
                        </div>
                    </div>
                </form>
                `;
                $('.table-responsive').html($create);
            })
        })
    </script>
@endsection