<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function userProfile(){
        $product = Product::orderBy('view_count','desc')->paginate(4);
        $data = User::where('id',Auth::user()->id)->get();
        return view('user.profile',compact('data','product'));
    }
    public function userPasswordChangePage(){
        $data = User::where('id',Auth::user()->id)->get();
        return view('user.password',compact('data'));
    }
}
