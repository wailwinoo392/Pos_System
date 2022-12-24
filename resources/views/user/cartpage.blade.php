@extends('user.layouts.master')
@section('leftContent')
<h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
<div class="p-30 mb-5">
    <div class="border-bottom pb-2">
        <div class="d-flex justify-content-between mb-3">
            <h6>Subtotal</h6>
            <h6 id="subTotal">{{ $totalPrice }} Kyats</h6>
        </div>
        <div class="d-flex justify-content-between">
            <h6 class="font-weight-medium">Delivery </h6>
            <h6 class="font-weight-medium">3000 Kyats</h6>
        </div>
    </div>
    <div class="pt-2">
        <div class="d-flex justify-content-between mt-2">
            <h5>Total</h5>
            <h5 id="finalTotal">@if($totalPrice > 0){{ $totalPrice+3000 }} @else{{ $totalPrice }} @endif Kyats</h5>
        </div>
        <button class="btn btn-block btn-warning font-weight-bold my-3 py-3 orderBtn">Proceed To Checkout</button>
    </div>
</div>
@endsection
@section('centerContent')
<table class="table table-light table-borderless table-hover text-center p-1" id="dataTable">
    <thead class="thead-dark">
        <tr>
            <th>Image</th>
            <th >Products</th>
            <th >Price</th>
            <th >Quantity</th>
            <th >Total</th>
            <th >Remove</th>
        </tr>
    </thead>
    <tbody class="align-middle">
        @foreach($data as $item)
        <tr>
            <td class="align-middle col-1"><img src="{{ asset('storage/'.$item->image )}}" alt="" style="width: 80%;"></td>
            <td class="align-middle" >{{ $item->product_name }}</td>
            <td class="align-middle" >{{ $item->product_price }} Kyats</td>
            <input type="hidden" name="" id="productPrice" value="{{ $item->product_price }}">
            <input type="hidden" name="" id="cartId" value="{{ $item->id }}">
            <input type="hidden" name="" id="productId" value="{{ $item->product_id}}">
            <input type="hidden" name="" id="userId" value="{{ Auth::user()->id }}">
            <td class="align-middle">
                <div class="input-group quantity mx-auto" style="width: 50%">
                    <div class="input-group-btn">
                        <button class="btn btn-sm btn-warning btn-minus" >
                        <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control form-control-sm bg-light border-0 text-center" id="productCount" value="{{ $item->qty }}">
                    <div class="input-group-btn">
                        <button class="btn btn-sm btn-warning btn-plus">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </td>
            <td class="align-middle col-2" id="qtyPrice">{{ $item->product_price * $item->qty }} Kyats</td>
            <td class="align-middle"><button class="btn btn-sm btn-danger removeBtn"><i class="fa fa-times"></i></button></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
@section('scriptSource')
<script>
    $(document).ready(function(){
        $('.btn-plus').click(function(){
            $parentNote = $(this).parents('tr');
            $count = $parentNote.find('#productCount').val();
            $price = $parentNote.find('#productPrice').val();
            $parentNote.find('#qtyPrice').html(`${$count * $price} Kyats`);
            summeryCalculation();
        })
        $('.btn-minus').click(function(){
            $parentNote = $(this).parents('tr');
            $count = $parentNote.find('#productCount').val();
            $price = $parentNote.find('#productPrice').val();
            $parentNote.find('#qtyPrice').html(`${$count * $price} Kyats`);
            summeryCalculation();
        })
        $('.removeBtn').click(function(){
            $parentNote = $(this).parents('tr');
            $data ={ 'cardId' : $parentNote.find('#cartId').val() };
            $parentNote.remove();
            console.log($data);
            $.ajax({
                type : 'get',
                url : '/user/ajax/remove/cart',
                data : Object.assign({}, $data),
                dataType : 'json',
            })
            summeryCalculation();
        })
        function summeryCalculation(){
            $totalPrice = 0;
            $('#dataTable tbody tr').each(function(index,row){
                $totalPrice += Number($(row).find('#qtyPrice').text().replace('Kyats',''));
            })
            $('#subTotal').html(`${$totalPrice} Kyats`);
            $totalPrice == 0 ? $('#finalTotal').html(`${$totalPrice} Kyats`) : $('#finalTotal').html(`${$totalPrice+3000} Kyats`); 
            
        }
        $('.orderBtn').click(function(){
            $orderList = [];
            $random = Math.floor(Math.random() * 1000000000001);
            $('#dataTable tbody tr').each(function(index,row){
                $orderList.push({
                    'productId' : $(row).find('#productId').val(),
                    'total' : $(row).find('#qtyPrice').text().replace('Kyats',''),
                    'qty' : $(row).find('#productCount').val(),
                    'order_code' : 'POS'+$(row).find('#userId').val()+'00000'+$random 
                });
            })
            $.ajax({
                type : 'get',
                url : '/user/ajax/order',
                data : Object.assign({},$orderList) ,
                dataType : 'json',
                success : function(response){
                    window.location.href = '/user/home';
                }
            })

        })
    })
</script>
@endsection