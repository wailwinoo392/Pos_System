<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Contact;
use App\Models\message;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RouteController extends Controller
{
    //product
    public function productList(){
        $data = Product::get();
        // $user = User::get();
        // $data = [
        //     'product' => $data,
        //     'user' => $user
        // ];
        return response()->json($data, 200);
    }
    public function productCreate(Request $request){
        $data = $this->dataValidationCheck($request , "create");
        $validator=Validator::make($request->all(),$data);
        if($validator->fails()) {
            $messages=$validator->messages();
            $errors=$messages->all();
            return response()->json(['message'=>$errors], 500);
        }
        $data = $this->getUserData($request);
        $imgName = uniqid().$request->file('productImage')->getClientOriginalName();
        $request->file('productImage')->storeAs('public/',$imgName);
        $data['image'] = $imgName;
        Product::create($data);
        $productList = Product::orderBy('created_at','desc')->get();
        return response()->json($productList, 200);
    }
    public function productUpdate(Request $request){
        $data = $this->dataValidationCheck($request , "update");
        $productIdDb = Product::where('id',$request->productId)->first();
        if(empty($productIdDb)){
            return response()->json(['message'=> 'there is no id for product update'], 500);
        }
        $validator=Validator::make($request->all(),$data);
        if($validator->fails()){
            $message = $validator->messages();
            $error = $message->all();
            return response()->json($error, 500);
        }
        $data = $this->getUserData($request);
        if($request->hasFile('productImage')){
            $oldImag = Product::where('id',$request->productId)->first();
            Storage::delete('public/'.$oldImag->image);
            $imgName = uniqid().$request->file('productImage')->getClientOriginalName();
            $request->file('productImage')->storeAs('public/',$imgName);
            $data['image'] = $imgName;
        }
        Product::where('id',$request->productId)->update($data);
        $productList = Product::orderBy('created_at','desc')->get();
        return response()->json($productList, 200);
    }
    public function productDelete($id){
        $data = Product::where('id',$id)->first();
        if(empty($data)){
            return response()->json(['message' => 'There is no product_id for product delete' ,'product_id' => $id], 500);
        }
        $oldImag = Product::where('id',$id)->first();
        Storage::delete('public/'.$oldImag->image);
        Product::where('id',$id)->delete();
        return response()->json(['message' => 'product Delete success' ,'product_id' => $id], 200);
        
    }

    //Category
    public function categoryList(){
        $categoryList = Category::get();
        return response()->json($categoryList, 200);
    }
    public function categoryDelete(Request $request){
        // return $request->all();
        $gg = Category::where('id',$request->category_id)->first();
        // return isset($data);// return !empty($data); 1 is true 0 is false
        if(isset($gg)){
            Category::where('id',$request->category_id)->delete();
            return response()->json(['message'=>'category delete success','delete data id' => $request->category_id], 200);
        }
        return response()->json(['message'=>'there is no id in database','delete data id' => $request->category_id], 200);
    }
    public function createCategory(Request $request){
        // dd($request->all()); //body data
        // dd($request->header('headerData')); //header data
        Category::create([
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $categoryList = Category::get();
        return response()->json($categoryList, 200);
    }
    public function updateCategory(Request $request){
        $gg = Category::where('id',$request->categoryId)->first();
        if(isset($gg)){
            Category::where('id',$request->categoryId)->update([
                'name' => $request->category
            ]);
            return response()->json(['message'=>'category Update success','update data id' => $request->categoryId], 200);
        }
        return response()->json(['message'=>'there is no category for update' ,'update data id' => $request->categoryId], 500);
    }

    //UserList
    public function userList(){
        $data = User::get();
        return response()->json($data, 200);
    }

    //message
    //user create or edit message
    public function userCreateMessage(Request $request){
        if($request->messageId){
            message::create([
                'user_id' => $request->user_id ,
                'unread_message' => $request->contactMessage
            ]);
            Contact::where('id',$request->messageId)->update([
                'message' => $request->contactMessage
            ]);
        }else{
            message::create([
                'user_id' => $request->user_id ,
                'unread_message' => $request->contactMessage
            ]);
            Contact::create([
                'user_id' => $request->user_id ,
                'message' => $request->contactMessage
            ]);
        }
        $data = message::where('user_id',$request->user_id)->select('user_id', DB::raw('SUM(unread_count) as total'))
        ->groupBy('user_id')
        ->get();
        foreach ($data->all() as $item){
            message::where('user_id',$item->user_id)->delete();
            $da = Contact::select('message')->where('user_id',$item->user_id)->latest()->first();
            message::create([
                'user_id' => $item->user_id,
                'unread_count' => $item->total,
                'unread_message' => $da->message
            ]);
        }
        $message = Contact::where('user_id',$request->user_id)->orderBy('created_at','desc')->get();
        return response()->json($message, 200);
    }
    //admin create message or edit message
    public function adminCreateMessage(Request $request){
        if($request->editmessageId){
            Contact::where('id',$request->editmessageId)->update([
                'message' => $request->contactMessage
            ]);
            message::create([
                'admin_id' => $request->adminId,
                'user_id' => $request->userId ,
                'unread_message' => $request->contactMessage
            ]);
        }else{
            message::create([
                'admin_id' => $request->adminId,
                'user_id' => $request->userId ,
                'unread_message' => $request->contactMessage
            ]);
            Contact::create([
                'admin_id' => $request->adminId,
                'user_id' => $request->userId ,
                'message' => $request->contactMessage
            ]);
        }
        $data = message::where('user_id',$request->userId)->select('user_id', DB::raw('SUM(unread_count) as total'))
        ->groupBy('user_id')
        ->get();
        message::where('user_id',$request->userId)->delete();
        $da = Contact::select('message')->where('admin_id',$request->adminId)->latest()->first();
        message::create([
            'admin_id'=> $request->adminId,
            'user_id' => $request->userId,
            'unread_count' => $data[0]->total,
            'unread_message' => $da->message
        ]);
        $data = Contact::where('user_id',$request->userId)->orderBy('created_at','desc')->get();
        return response()->json($data, 200);
    }
    public function messageDelete($id){
        $gg = Contact::where('id',$id)->first();
        if(isset($gg)){
            Contact::where('id',$id)->delete();
            return response()->json(['message'=>'message delete success','delete data id' => $id], 200);
        }
        return response()->json(['message'=>'there is no id in database' ,'delete data id' => $id], 200);
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
        return $validationRule;
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
}


