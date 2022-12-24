@extends('user.layouts.master')
@section('title','Customer Home')
@section('content')
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-3 col-md-4">
            @section('leftContent')
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by Category</span></h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="d-flex align-items-center justify-content-between mb-4 bg-dark text-white px-4 py-3 shadow-sm">
                        <label class="mt-2" for="price-all">Categories</label>
                        <span class="badge border font-weight-normal ">{{ count($category) }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3 ">
                        <a href="{{ route('user#home')}}" class="text-dark "><label class="ms-1 border-bottom border-dark" for="price-all">All</label></a>
                    </div>
                    @foreach ($category as $ctg)
                    <span>
                        <div class="productCategoryForEach d-flex align-items-center justify-content-between mb-3 ">
                            <a href="{{route('user#productFilter',$ctg->id)}}" class="text-dark " ><label class="ms-1" for="price-all">{{ $ctg->name  }}</label></a>
                        </div>
                        <input type="hidden" name="categoryIdForEach" id="categoryIdForEach" value="{{ $ctg->id}}">
                    </span>
                    @endforeach
                </form>
            </div>
            <div class="">
                <a href="{{ route('userOrderHistory')}}" class="btn btn btn-warning w-100">Order</a>
            </div>
            @endsection
            @section('centerContent')
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-md-flex align-items-center justify-content-between mb-4 ">
                        <div class="my-3 my-md-0">
                          <a class="me-2" href="{{ route('user#cartPage')}}"><button type="button" class="btn btn-dark position-relative rounded">
                            <i class="fa-solid fa-cart-plus "></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ count($cart) }}
                          </button></a>
                          <a class="me-2" href="{{ route('userOrderHistory')}}"><button type="button" class="btn btn-dark position-relative rounded">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ count($order) }}
                          </button></a>
                          <a class="" href="{{ route('user#messagePage')}}"><button type="button" class="btn btn-dark position-relative rounded">
                            <i class="fa-regular fa-envelope fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $unreadCountTotal }}
                          </button></a>

                        </div>
                        <div class="">
                            <input type="text" id="searchTxt" placeholder="Search Product" class="form-control">
                        </div>
                        <div class="ml-2 d-none d-md-inline">
                            <div class="btn-group">
                                <select class="form-control" name="sorting" id="sortingOption">
                                    <option class="dropdown-item"  value="">Choose Option</option>
                                    <option class="dropdown-item"  value="asc">Ascending</option>
                                    <option class="dropdown-item" value="desc">Descending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <span class="row" id="dataList">
                    @if ( count($product) == null)
                        <h2 class="text-center mt-5 col-6 offset-3 shadow-lg p-5">There is no Data <i class="fa-solid fa-pizza-slice ms-2"></i></h2>
                    @endif
                    @foreach ($product as $p )
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1" >
                            <div class="product-item bg-light mb-4" id="myForm" >
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" style="height: 290px;" src="{{ asset('storage/'.$p->image)}}" alt="">
                                    <div class="product-action foreachAmp">
                                        <a class="btn btn-outline-dark btn-square" href="{{ route('user#productDetail',$p->id)}}"><i class="fa fa-shopping-cart"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="">{{ $p->name }}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        {{-- <h5>20000 kyats</h5><h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                        <h5>{{ $p->price }}</h5>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        <small class="fa fa-star text-warning mr-1"></small>
                                        <small class="fa fa-star text-warning mr-1"></small>
                                        <small class="fa fa-star text-warning mr-1"></small>
                                        <small class="fa fa-star text-warning mr-1"></small>
                                        <small class="fa fa-star text-warning mr-1"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{ $product->appends(request()->query())->links()}}
                </span>
                <div class="mt-3 ">
                    
                </div>
            </div>
            @endsection
        </div>
        <!-- Shop Product Start -->
        
        <!-- Shop Product End -->
    </div>
</div>
@endsection
@section('scriptSource')
<script>
    $(document).ready(function(){
        $('#sortingOption').change(function(){
            $sorting = $('#sortingOption').val();
            $.ajax({
                type : 'get',
                url : '/user/ajax/orderSorting',
                data : {'status' : $sorting },
                // headers : {},
                dataType : 'json',
                success : function(response){
                    $list = '';
                    for($i=0;$i<response.length;$i++){
                        $list +=`
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1" >
                            <div class="product-item bg-light mb-4" id="myForm" >
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" style="height: 290px;" src="{{ asset('storage/${response[$i].image}')}}" alt="">
                                    <div class="product-action foreachAmp">
                                        <a class="btn btn-outline-dark btn-square" href="{{ url('user/product/detail/${response[$i].id}' )}}"><i class="fa fa-shopping-cart"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href=""> ${response[$i].name} </a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>${response[$i].price}</h5>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        <small class="fa fa-star text-warning mr-1"></small>
                                        <small class="fa fa-star text-warning mr-1"></small>
                                        <small class="fa fa-star text-warning mr-1"></small>
                                        <small class="fa fa-star text-warning mr-1"></small>
                                        <small class="fa fa-star text-warning mr-1"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `; 
                    }
                    $('#dataList').html($list);
                }
            })
        })
        
        // $('.productCategoryForEach').hover(function(){
        //     $parentNote = $(this).parents('span');
        //     $data = $parentNote.find('#categoryIdForEach').val();
        //     $.ajax({
        //         type : 'get',
        //         url : '/user/ajax/order/category',
        //         data : { 'categoryId' : $data},
        //         dataType : 'json',
        //         success : function(response){
        //             $list = '';
        //             for($i=0;$i<response.length;$i++){
        //                 $list += `
        //                 <div class="col-lg-4 col-md-6 col-sm-6 pb-1" >
        //                     <div class="product-item bg-light mb-4" id="myForm" >
        //                         <div class="product-img position-relative overflow-hidden">
        //                             <img class="img-fluid w-100" style="height: 290px;" src="{{ asset('storage/${response[$i].image}')}}" alt="">
        //                             <div class="product-action foreachAmp">
        //                                 <a class="btn btn-outline-dark btn-square " href="" ><i class="fa fa-shopping-cart"></i></a>
        //                                 <a class="btn btn-outline-dark btn-square" href="{{ url('user/product/detail/${response[$i].id}' )}}"><i class="fa-solid fa-info"></i></a>
        //                             </div>
        //                         </div>
        //                         <div class="text-center py-4">
        //                             <a class="h6 text-decoration-none text-truncate" href=""> ${response[$i].name} </a>
        //                             <div class="d-flex align-items-center justify-content-center mt-2">
        //                                 <h5>${response[$i].price}</h5>
        //                             </div>
        //                             <div class="d-flex align-items-center justify-content-center mb-1">
        //                                 <small class="fa fa-star text-warning mr-1"></small>
        //                                 <small class="fa fa-star text-warning mr-1"></small>
        //                                 <small class="fa fa-star text-warning mr-1"></small>
        //                                 <small class="fa fa-star text-warning mr-1"></small>
        //                                 <small class="fa fa-star text-warning mr-1"></small>
        //                             </div>
        //                         </div>
        //                     </div>
        //                 </div>
        //                 `;
        //             }
        //             $('#dataList').html($list);
        //         }
        //     })
        // })
        $('#searchTxt').keyup(function(){
            $searchKey = $('#searchTxt').val();
            $.ajax({
                type :'get',
                url :'/user/ajax/productSearch',
                data : { 'searchKey' : $searchKey},
                dataType : 'json',
                success : function(response){
                    $list = '';
                    for($i=0;$i<response.length;$i++){
                        $list += `
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1" >
                            <div class="product-item bg-light mb-4" id="myForm" >
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" style="height: 290px;" src="{{ asset('storage/${response[$i].image}')}}" alt="">
                                    <div class="product-action foreachAmp">
                                        <a class="btn btn-outline-dark btn-square" href="{{ url('user/product/detail/${response[$i].id}' )}}"><i class="fa fa-shopping-cart"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href=""> ${response[$i].name} </a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>${response[$i].price}</h5>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        <small class="fa fa-star text-warning mr-1"></small>
                                        <small class="fa fa-star text-warning mr-1"></small>
                                        <small class="fa fa-star text-warning mr-1"></small>
                                        <small class="fa fa-star text-warning mr-1"></small>
                                        <small class="fa fa-star text-warning mr-1"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                    }
                    $('#dataList').html($list);
                }
            })
        })
    })
</script>
@endsection
