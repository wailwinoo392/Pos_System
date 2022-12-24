@extends('user.layouts.master')
@section('title','History')
@section('leftContent')
<div class="mt-5" >
    <h4 class="ms-md-3" id="list2">Most Popular</h4>
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
        {{ $product->appends(request()->query())->links()}}
    </table>
</div>
@endsection
@section('centerContent')
<div class="p-md-3">
    <a class="text-dark" href="{{ route('user#home')}}"><i class="fa-solid fa-arrow-left"></i></a>
                    
    <h3 class="text-center title-2">Order History</h3>
    <table class="table  table-hover text-center mb-0" id="dataTableOrder">
        <thead class="">
            <tr>
                <th class="">Email</th>
                <th class="">Order Code</th>
                <th class="">Total Price</th></th>
                <th class="">Created At</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody class="align-middle">
            @foreach($data as $item)
            <tr>
                <td class="align-middle" >{{ $item->user_email}}</td>
                <td class="align-middle text-dark" style="width: 5%"><a class="text-dark clickOrderCode"  href="#" >{{ $item->order_code }}</a></td>
                <input type="hidden" name="" value="{{ $item->order_code }}" id="clickOrderCode">
                <td class="align-middle">{{ $item->total_price }} Kyats</td>
                <td class="align-middle" >{{ $item->created_at->format('j-M-Y') }}</td>
                <td class="align-middle" >
                    @if($item->status == 0 )
                    <p class="mt-3 px-1 py-1 btn-warning"><i class="me-2 fa-regular fa-clock"></i>Pending</p>
                    @elseif($item->status == 1)
                    <p class="mt-3 px-1 py-1 btn-success"><i class="me-2 fa-solid fa-check"></i> Accept</p>
                    @else
                    <p class="mt-3 px-1 py-1 btn-danger"><i class="me-2 fa-solid fa-exclamation"></i>Reject</p>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('scriptSource')
<script>
    $(document).ready(function(){
        $('.clickOrderCode').click(function(){
            $parentNote = $(this).parents('tr');
            $orderCode ={orderCode : $parentNote.find('#clickOrderCode').val()};
            $url = '/user/ajax/orderDetail';
            $.ajax({
                type : 'get',
                url : $url,
                data : Object.assign({}, $orderCode),
                dataType : 'json',
                success : function(response){
                    $list = '';
                    $list1 = `
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    `;
                    $list2 = `${$orderCode['orderCode']}
                    `;
                    for($i=0;$i<response.length;$i++){
                        
                        $list += `
                            <tr>
                                <td class="align-middle" >${response[$i].product_name}</td>
                                <td class="align-middle" >${response[$i].product_price}</td>
                                <td class="align-middle" >${response[$i].qty}</td>
                                <td class="align-middle" >${response[$i].total}</td>
                                    
                            </tr>
                        `;
                    }
                    $('#list').html($list);
                    $('#list1').html($list1);
                    $('#list2').html($list2);
                }
            })
        })
    })
</script>
@endsection