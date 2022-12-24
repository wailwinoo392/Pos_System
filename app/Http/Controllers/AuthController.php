<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\message;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function logIn(){
        return view('login');
    }
    public function register(){
        return view('register');
    }
    public function adminHome(){
        $unreadMessageList = message::select('messages.*','users.name as user_name')
        ->leftjoin('users','users.id','messages.user_id')
        ->whereNull('messages.admin_id')
        ->orderBy('created_at','desc')
        ->get();
        $customerCount = count(User::get());
        $productCount = count(Product::get());
        $orderCount = count(Order::get());
        $unreadCountTotal = DB::table('messages')->whereNull('admin_id')->sum('unread_count');
        if($unreadCountTotal == 0){
            message::where('unread_count',0)->delete();
        }
        return view('admin.home',compact('unreadCountTotal','unreadMessageList','orderCount','customerCount','productCount'));
    }
    public function userHome(){
        $unreadCountTotal = DB::table('messages')->where('admin_id','>','0')->where('user_id',Auth::user()->id)->sum('unread_count');
        $order = Order::where('user_id',Auth::user()->id)->get();
        $category = Category::get();
        $product = Product::paginate(6);
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        // $categories = Product::select('products.*','categories.name as category_name')
        // ->leftjoin('categories','categories.id','products.category_id')
        // ->get();
        // $collection = collect($categories);
        // $coun = $collection->countBy(function ($item) {
        //     return $item->category_name;
        // });
        return view('user.home',compact('order','category','product','cart','unreadCountTotal'));
    }
    public function dashboard(){
        if(Auth::user()->role == 'admin'){
            return redirect()->route('admin#home');
        }
        return redirect()->route('user#home');
    }
}

