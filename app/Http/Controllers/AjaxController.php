<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\message;
use App\Models\Product;
use App\Models\Ratting;
use App\Models\Category;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function addToCart(Request $request){
        Cart::create([
            'product_id' => $request->productId,
            'user_id' => Auth::user()->id,
            'qty' => $request->qty
        ]);
        $response = [
            'message' => 'Add To Cart Complete',
            'status' => 'Success'
        ];
        return response()->json($response, 200);
    }
    public function removeCart(Request $request){
        Cart::where('id',$request->cardId)->delete();
    }
    public function order(Request $request){
        $total = 0;
        foreach ($request->all() as $item){
             $data = OrderList::create([
                'user_id'=> Auth::user()->id,
                'product_id' => $item['productId'],
                'total' => $item['total'],
                'qty' => $item['qty'],
                'order_code' => $item['order_code']
            ]);
            $total += $data->total;
        }
        Cart::where('user_id',Auth::user()->id)->delete();
        Order::Create([
            'user_id' => Auth::user()->id,
            'total_price' => $total+3000,
            'order_code' => $data->order_code
        ]);
        return response()->json([
            'status' => 'Success',
        ], 200);
    }
    public function orderDetail(Request $request){
        $data = OrderList::select('order_lists.*','products.name as product_name','products.price as product_price')
        ->leftjoin('products','products.id','order_lists.product_id')
        ->where('order_lists.order_code',$request->orderCode)->get();
        return response()->json($data, 200);
    }
    public function orderSorting(Request $request){
        $data = Product::orderBy('updated_at',$request->status)->get();
        return response()->json($data, 200);
    }
    public function orderCategory($id){
        $unreadCountTotal = DB::table('messages')->where('admin_id','>','0')->where('user_id',Auth::user()->id)->sum('unread_count');
        $order = Order::where('user_id',Auth::user()->id)->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $product = Product::where('category_id',$id)->paginate(6);
        return view('user.home',compact('product','category','order','cart','unreadCountTotal'));
    }
    public function searchProduct(Request $request){
        $data = Product::where('name','like','%'.$request->searchKey.'%')
        ->orWhere('price','like','%'.$request->searchKey.'%')->get();
        // ->orWhere('price',[$request->searchKey-11000,$request->searchKey+11000])->get();
        return response()->json($data, 200);
    }
    public function adminChangeStatus(Request $request){
        logger($request->toArray);
        Order::where('id',$request->orderId)->update([
            'status' => $request->status
        ]);
    }
    public function adminRolechange(Request $request){
        logger($request->toArray());
        User::where('id',$request->userId)->update([
            'role' => $request->role
        ]);
    }
    public function reviewDelete(Request $request){
        Ratting::where('id',$request->reviewId)->delete();
        $dat = Product::select('products.id as product_id', DB::raw('COUNT(rattings.product_id) as count'))
        ->leftjoin('rattings','rattings.product_id','products.id')
        ->groupBy('products.id')
        ->get();
        foreach ($dat->all() as $item){
            Product::where('id',$item->product_id)->update([
                'review_count' => $item->count
            ]);
        }
    }
    public function messageDeleted(Request $request){
        Contact::where('id',$request->messageId)->delete();
    }
    public function adminNameSearch(Request $request){
        $data = User::where('name','like','%'.$request->key.'%')->get();
        $unreadMessageList = message::select('messages.*','users.name as user_name')
        ->leftjoin('users','users.id','messages.user_id')
        ->whereNull('messages.admin_id')
        ->orderBy('created_at','desc')
        ->get();        
        $unreadCountTotal = DB::table('messages')->whereNull('admin_id')->sum('unread_count');
        return view('admin.alluserlist',compact('data','unreadCountTotal','unreadMessageList'));
    }
}
