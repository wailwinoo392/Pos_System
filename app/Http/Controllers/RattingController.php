<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Ratting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RattingController extends Controller
{
    public function productReview(Request $request){
        if($request->reviewId){
            Ratting::where('id',$request->reviewId)->update([
                'user_id'=> Auth::user()->id,
                'product_id'=> $request->productId,
                'review'=>$request->message
            ]);
        }else{
            Ratting::create([
                'user_id'=> Auth::user()->id,
                'product_id'=> $request->productId,
                'review'=>$request->message
            ]);
        }
        $dat = Product::select('products.id as product_id', DB::raw('COUNT(rattings.product_id) as count'))
        ->leftjoin('rattings','rattings.product_id','products.id')
        ->groupBy('products.id')
        ->get();
        foreach ($dat->all() as $item){
            Product::where('id',$item->product_id)->update([
                'review_count' => $item->count
            ]);
        }
        return redirect()->route('user#productDetail',$request->productId);
    }
}
