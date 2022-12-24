@extends('user.layouts.master')
@section('centerContent')

@section('content')
<div class="container-fluid">
    <div class="row px-xl-5">
        <a href="{{ route('user#home')}}"><i class="fa-solid fa-left-long mb-3 text-dark"></i> </a>
        <div class="col-lg-5 mb-30">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner bg-light">
                    <div class="carousel-item active">
                        <img class="w-100 h-100" src="{{ asset('storage/'.$firstData->image )}}" alt="Image">
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" value="{{ $firstData->id }}" id="productId">
        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <h1>{{ $firstData->name}}</h1>
                <div class="d-flex mb-3">
                    <div class="text-warning mr-2">
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small>
                    </div>
                    <small class="pt-1">{{ $firstData->view_count +1 }}<i class="ms-2 fa-regular fa-eye"></i></small>
                </div>
                <h3 class="font-weight-semi-bold mb-4">{{ $firstData->price}} Kyats</h3>
                <p class="mb-4">{{ $firstData->description}}</p>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-warning btn-minus ">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="number" class="form-control bg-light border-0 text-center px-1 qtyCount" id="orderCount" value="0">
                        <div class="input-group-btn">
                            <button class="btn btn-warning btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-warning px-3" id="addCartBtn"><i class="fa fa-shopping-cart mr-1"></i> Add To
                        Cart</button>{{--  must type = buttom --}}
                </div>
                <small id="qtyError" class="text-danger"></small>
                <div class="d-flex pt-2">
                    <strong class="text-dark mr-2">Share on:</strong>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-2">
    <div class="row px-xl-5">
        <div class="col">
            <div class="bg-light p-30 shadow-sm mb-4">
                <div class="row ">
                    <div class="col-md-8 ">
                        <h4 class="mb-4">{{ count($review) }} review for {{ $firstData->name}}</h4>
                        @foreach($review as $item)
                        <div class="media mb-3 shadow-sm col-12">
                            @if($item->gender == 'male' && $item->user_image == null )
                            <img class="img-fluid mr-3 mt-1" style="width: 45px;" src="{{ asset('image/male_user_default.jpeg')}}"/>
                            @elseif($item->gender == 'female' && $item->user_image == null)
                            <img class="img-fluid mr-3 mt-1" style="width: 45px;"  src="{{ asset('image/female_user_default.jpeg')}}"/>
                            @else
                            <img class="img-fluid mr-3 mt-1" style="width: 45px;"  src="{{ asset('storage/'.$item->user_image)}}"/>
                            @endif
                            <div class="media-body ">
                                <span>
                                    <div class="d-flex justify-content-between ">
                                        <h6>{{$item->user_name}}</h6><small> <i>{{ $item->updated_at->diffForHumans()}} </i></small>
                                    </div>
                                    {{-- <div class="text-warning mb-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                    </div> --}}
                                    <p >{{$item->review }}</p>
                                    <input type="hidden" class="reviewDetailOld" value="{{$item->review }}" name="">
                                    <div class="float-end mb-3 ">
                                        <input type="hidden" class="reviewId" name="reviewId" id="review" value="{{ $item->id}}" >
                                        <a href="#" onclick="return false;" class="text-dark reviewDelete @if(Auth::user()->role == 'admin')  @elseif(Auth::user()->id != $item->user_id) d-none @endif">Delete</a>
                                        <input type="hidden" name="" id="reviewEdit" value="edit">
                                        <a href="#" onclick="return false;" class="text-dark reviewEdit" >@if($item->created_at != $item->updated_at) Updated @elseif(Auth::user()->id == $item->user_id) Edit @endif</a>
                                    </div>
                                </span>
                            </div>
                        </div>
                        @endforeach
                        {{ $review->appends(request()->query())->links()}}
                    </div>
                    <div class="col-md-4">
                        <h4 class="mb-4">Leave a review</h4>
                        <small>Your email address will not be published. Required fields are marked *</small>
                        <div class="d-flex my-3">
                            <p class="mb-0 mr-2">Your Rating * :</p>
                            <span class=" rating">
                                <i class="far fa-star rating"></i>
                                <i class="far fa-star rating"></i>
                                <i class="far fa-star rating"></i>
                                <i class="far fa-star rating"></i>
                                <i class="far fa-star rating"></i>
                            </span>
                        </div>
                        <div id="dataList">
                            <form action="{{route('product#review')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="message">Your Review *</label>
                                    <input type="hidden" value="{{ $firstData->id }}" name="productId">
                                    <textarea name="message" cols="30" rows="5" class="form-control" required></textarea>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit"  class="btn btn-warning px-3">Review</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach ($allData as $pizza )
                <div class="product-item bg-light">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" style="height: 300px;" src="{{ asset('storage/'.$pizza->image)}}" alt="">
                        <div class="product-action">
                            {{-- <a class="btn btn-outline-dark btn-square" href="{{route('user#addToCart',$pizza->id )}}"><i class="fa fa-shopping-cart"></i></a> --}}
                            <a class="btn btn-outline-dark btn-square" href="{{route('user#productDetail',$pizza->id )}}"><i class="fa fa-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="">{{$pizza->name}}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>{{$pizza->price}}</h5><h6 class="text-muted ml-2"><del>{{intval($pizza->price)+3000}}</del></h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <small class="fa fa-star text-warning mr-1"></small>
                            <small class="fa fa-star text-warning mr-1"></small>
                            <small class="fa fa-star text-warning mr-1"></small>
                            <small class="fa fa-star text-warning mr-1"></small>
                            <small class="fa fa-star text-warning mr-1"></small>
                            <small><i class="fa-regular fa-eye"></i> {{ $pizza->view_count+1}}</small>
                        </div>
                    </div>
                </div>                    
                @endforeach
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('scriptSource')
<script>
    $(document).ready(function(){
        $('#addCartBtn').click(function(){
            if($('#orderCount').val() > 0 ){
                $sources = {
                    'qty' : $('#orderCount').val(),
                    'productId' : $('#productId').val()
                }
                $.ajax({
                    type : 'get',
                    url : '/user/ajax/add/cart',
                    data : $sources ,
                    dataType : 'json',
                    success : function(response){
                        window.location.href = "/user/home";
                    }
                })
            }else{
                $('#qtyError').html('Quantity Must Not Be 0');
            }
        })
        $('.reviewDelete').click(function(){
            $parentNote = $(this).parents('span');
            $reviewId = {'reviewId' : $parentNote.find('#review').val()};
            $parentNote.html('<i class="fa-regular fa-trash-can"></i> Review Delete');
            $.ajax({
                'type' : 'get',
                'url' : '/user/ajax/review/delete',
                'data' : $reviewId,
                'dataType' : 'json'
            })
        })
        $('.reviewEdit').click(function(){
            $parentNote = $(this).parents('span');
            $reviewId = $parentNote.find('#review').val();
            $reviewOld = $parentNote.find('.reviewDetailOld').val();
            $d = $('#ggaadd').val();
            $a = `
            <form action="{{route('product#review')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="message">Edit Your Review</label>
                    <input type="hidden" value="{{ $firstData->id }}" name="productId">
                    <input type="hidden" name="reviewId" id="ggaadd" value="${$reviewId}">
                    <textarea name="message" cols="30" rows="5" class="form-control" required>${$reviewOld}</textarea>
                </div>
                <div class="form-group mb-0">
                    <button type="submit"  class="btn btn-warning px-3">Update</button>
                </div>
            </form>
            `;
            $b = `
            <form action="{{route('product#review')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="message">Your Review *</label>
                    <input type="hidden" value="{{ $firstData->id }}" name="productId">
                    <textarea name="message" cols="30" rows="5" class="form-control" required></textarea>
                </div>
                <div class="form-group mb-0">
                    <button type="submit"  class="btn btn-warning px-3">Review</button>
                </div>
            </form>
            `;
            if($parentNote.find('#reviewEdit').val() == 'edit'  ){
                $('#dataList').html($a);
                $parentNote.find('.reviewEdit').html('Cancel');
            }
            if($d != null){
                $('#dataList').html($b);
                $parentNote.find('.reviewEdit').html('Edit');
            }
        })


    })
</script>
@endsection
