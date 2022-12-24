<?php

namespace App\Http\Controllers;

use App\Models\message;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function adminCategoryList(){
        $unreadMessageList = message::select('messages.*','users.name as user_name')
        ->leftjoin('users','users.id','messages.user_id')
        ->whereNull('messages.admin_id')
        ->orderBy('created_at','desc')
        ->get();
        $unreadCountTotal = DB::table('messages')->whereNull('admin_id')->sum('unread_count');
        $data = Category::paginate(4);
        return view('admin.categorylist',compact('data','unreadCountTotal','unreadMessageList'));
    }
    
    public function adminCategoryCreate(Request $request){
        $data = Category::select('name')->where('name',$request->category)->first();
        if($data){
            return redirect()->route('admin#categoryList')->with(['categoryDuplicate' => 'Your Categoryt is Alerady Taken']);
        }else{
            Category::create([
                'name' => $request->category
            ]);
            return redirect()->route('admin#categoryList')->with(['categoryCreate' => 'Category Created !']);
        }
    }

    public function adminCategoryDelete($id){
        Category::where('id',$id)->delete();
        return back()->with(['categoryDeleteSuccess'=> 'Category Delete Success']);
    }

    public function adminCategoryUpdated(Request $request){
        $data = Category::where('name',$request->category)->first();
        if($data){
            return redirect()->route('admin#categoryList')->with(['categoryDuplicate' => 'Edit Category Name is Equal Old Category Name !']);
        }else{
            Category::where('id',$request->categoryId)->update([
                'id' => $request->categoryId,
                'name' => $request->category,
                'updated_at' => Carbon::now()
            ]);
            return redirect()->route('admin#categoryList')->with(['CategoryCreate' => ' Category Updated !']);
        }
    }

}
