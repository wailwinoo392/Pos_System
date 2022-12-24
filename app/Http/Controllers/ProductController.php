<?php

namespace App\Http\Controllers;

use App\Models\message;
use App\Models\Product;
use App\Models\Ratting;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //admin product
    public function adminProductList(){
        $data = Product::select('products.*','categories.name as category_id')
        ->leftjoin('categories','categories.id','products.category_id')
        ->paginate(6);
        $unreadMessageList = $this->importantMessage($data);
        $unreadCountTotal = DB::table('messages')->whereNull('admin_id')->sum('unread_count');
        return view('admin.productlist',compact('data','unreadCountTotal','unreadMessageList'));
    }
    public function adminProductCreatePage(){
        $data = Category::get();
        return view('admin.productcreate',compact('data'));
    }
    public function adminProductCreated(Request $request){
        $this->dataValidationCheck($request ,"create");
        $data = $this->getUserData($request);
        $imgName = uniqid(). $request->file('productImage')->getClientOriginalName();
        $request->file('productImage')->storeAs('public/',$imgName);
        $data['image'] = $imgName ;
        Product::create($data);
        return redirect()->route('admin#productList')->with(['categoryCreate' => 'Product Create Success']);
    }
    public function adminProductDeleted($id){
        $data = Product::where('id',$id)->first();
        Storage::delete(['public/'.$data->image]);
        Product::where('id',$id)->delete();
        return redirect()->route('admin#productList')->with(['categoryCreate' => 'Product Delete Success !']);
    }
    public function adminProductUpdatePage($id){
        $data = Product::where('id',$id)->first();
        $category = Category::get();
        $review = Ratting::select('rattings.*','users.name as user_name','users.image as user_image','users.gender')
        ->leftjoin('users','users.id','rattings.user_id')
        ->where('rattings.product_id',$id)
        ->orderBy('updated_at','desc')
        ->paginate(5);
        return view('admin.productedit',compact('data','category','review'));
    }
    public function adminProductUpdated(Request $request){
        dd($request->all());
        $this->dataValidationCheck($request , "update");
        $data = $this->getUserData($request);
        $oldImg = Product::select('image')->where('id',$request->productId)->first();
        if($request->hasFile('productImage')){
            Storage::delete('public/'.$oldImg->image);
            $imgName = uniqid() . $request->file('productImage')->getClientOriginalName();
            $request->file('productImage')->storeAs('public/',$imgName);
            $data['image'] = $imgName;
        }
        Product::where('id',$request->productId)->update($data);
        return redirect()->route('admin#productList')->with(['categoryCreate' => 'Product Updae Success !']);
    }

    //user product
    public function userProductDetail($id){
        $firstData = Product::where('id',$id)->first();
        $allData = Product::get();
        $review = Ratting::select('rattings.*','users.name as user_name','users.image as user_image','users.gender')
        ->leftjoin('users','users.id','rattings.user_id')
        ->where('rattings.product_id',$id)
        ->orderBy('updated_at','desc')
        ->paginate(5);
        $data = Ratting::where('user_id',Auth::user()->id)
                ->where('product_id',$id)
                ->first();
        if($data == null){
            $data = Product::where('id',$id)->first();
            Product::where('id',$id)->update([
                'view_count' => $data->view_count + 1 
            ]);
        }
        return view('user.productdetail',compact('firstData','allData','review'));
    }


    private function dataValidationCheck($request , $action){
        $validationRule = [
            'productName' => 'required|min:3|unique:products,name,'.$request->productId ,
            'productPrice' => 'required',
            'productDescription' => 'required',
            'waitingTime' => 'required',
            'categoryId'=> 'required',
            'productImage' => 'required|mimes:jpeg,jpg,png,webp|file'
        ];
        $validationRule['productImage'] = $action == "create" ? 'required|mimes:jpeg,jpg,png,webp|file' : 'mimes:jpeg,jpg,png,webp|file';
        Validator::make($request->all(),$validationRule)->validate();
    }
    private function getUserData($request){
        return [
            'name' => $request->productName,
            'price' => $request->productPrice,
            'category_id' => $request->categoryId,
            'waiting_time' => $request->waitingTime,
            'description' => $request->productDescription
        ];
    }
    private function importantMessage($data){
        return $data = message::select('messages.*','users.name as user_name')
        ->leftjoin('users','users.id','messages.user_id')
        ->whereNull('messages.admin_id')
        ->orderBy('created_at','desc')
        ->get();
    }
}
