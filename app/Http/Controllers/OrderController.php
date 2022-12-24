<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\message;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function userOrderHistory(){
        $product = Product::orderBy('review_count','desc')->paginate(4);
        $data = Order::select('orders.*','users.name as user_name','users.email as user_email')
        ->leftjoin('users','users.id','orders.user_id')
        ->where('user_id',Auth::user()->id)->get();
        return view('user.orderhistory',compact('data','product'));
    }
    public function adminOrderList(){
        $data = Order::select('orders.*','users.name as user_name','users.email as user_email')
        ->leftjoin('users','users.id','orders.user_id')
        ->where('orders.status','0')
        ->get();
        $unreadMessageList = $this->importantMessage($data);
        $unreadCountTotal = DB::table('messages')->whereNull('admin_id')->sum('unread_count');
        return view('admin.orderlist',compact('data','unreadCountTotal','unreadMessageList'));
    }
    public function adminOrderStatus(Request $request){
        $dat = Order::select('orders.*','users.name as user_name','users.email as user_email')
        ->leftjoin('users','users.id','orders.user_id');
        if($request->orderStatusSearch == null){
            $data = $dat->where('status',0)->get();
        }else{
            $data = $dat->where('status',$request->orderStatusSearch)->get();
        }
        $unreadMessageList = $this->importantMessage($data);
        $unreadCountTotal = DB::table('messages')->whereNull('admin_id')->sum('unread_count');
        return view('admin.orderlist',compact('data','unreadCountTotal','unreadMessageList'));
    }
    public function userOrderDetail($id){
        $order = Order::where('order_code',$id)->first();
        $data = OrderList::select('order_lists.*','products.name as product_name','users.name as user_name','users.email','products.image as product_image','users.image as user_image','users.phone','users.address','products.price')
        ->leftjoin('users','users.id','order_lists.user_id')
        ->leftjoin('products','products.id','order_lists.product_id')
        ->where('order_lists.order_code',$id)
        ->get();
        $unreadMessageList = $this->importantMessage($data);
        $unreadCountTotal = DB::table('messages')->whereNull('admin_id')->sum('unread_count');
        return view('admin.orderinfo',compact('data','order','unreadCountTotal','unreadMessageList'));
    }
    private function importantMessage($data){
        return $data = message::select('messages.*','users.name as user_name')
        ->leftjoin('users','users.id','messages.user_id')
        ->whereNull('messages.admin_id')
        ->orderBy('created_at','desc')
        ->get();
    }
}
