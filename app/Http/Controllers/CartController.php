<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function userCartPage(){
        $data = Cart::select('carts.*','products.name as product_name','products.price as product_price','products.image','products.id as product_id')
        ->leftjoin('products','products.id','carts.product_id')
        ->where('carts.user_id',Auth::user()->id)
        ->get();
        $totalPrice = 0;
        foreach($data as $items){
            $totalPrice += $items->product_price * $items->qty;
        }
        return view('user.cartpage',compact('data','totalPrice'));
    }
}
