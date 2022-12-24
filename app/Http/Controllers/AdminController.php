<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function adminProfile(){
        return view('admin.profile');
    }
    public function adminUpdate(Request $request){
        $this->accountValidationCheck($request);
        if(Hash::check($request->password,Auth::user()->password)){
            $data = $this->getUserData($request);
            if($request->hasFile('image')){
                if( Auth::user()->image != null ){
                    Storage::delete('public/'.Auth::user()->image );
                };
                $imgName = uniqid(). $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/',$imgName);
                $data['image'] = $imgName ;
            };
            User::where('id',Auth::user()->id)->update($data);
            if(Auth::user()->role == 'admin'){
                return redirect()->route('admin#profile')->with(['updateSuccess' => 'Updated']);
            }else{
                return redirect()->route('user#accountProfile')->with(['updateSuccess' => 'Updated']);
            }
        };
        return back()->with(['notMatch' => 'Your Password Not Match , Try Again']);
    }

    public function adminPasswordChangePage(){
        return view('admin.password');
    }
    public function adminPasswordChange(Request $request){
        Validator::make($request->all(),[
            'oldPassword' => 'required',
            'newPassword' => 'required|different:oldPassword',
            'confirmPassword'=> 'required|same:newPassword'
        ],[])->validate();
        if(Hash::check($request->oldPassword, Auth::user()->password )){
            User::where('id',Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            Auth::logout();
            return redirect()->route('auth#logInPage')->with(['updateSuccess' => 'Password Change Successfully']);
        };
        return back()->with(['notMatch' => 'Your Password Not Match , Try Again']);
    }

    public function adminAllUserList(){
        $unreadMessageList = message::select('messages.*','users.name as user_name')
        ->leftjoin('users','users.id','messages.user_id')
        ->whereNull('messages.admin_id')
        ->orderBy('created_at','desc')
        ->get();        
        $unreadCountTotal = DB::table('messages')->whereNull('admin_id')->sum('unread_count');
        $data = User::where('role','admin')->get();
        return view('admin.alluserlist',compact('data','unreadCountTotal','unreadMessageList'));
    }
    public function adminUserRole(Request $request){
        $unreadCountTotal = DB::table('messages')->whereNull('admin_id')->sum('unread_count');
        $unreadMessageList = message::select('messages.*','users.name as user_name')
        ->leftjoin('users','users.id','messages.user_id')
        ->whereNull('messages.admin_id')
        ->orderBy('created_at','desc')
        ->get();
        $data = User::where('role',$request->role)->get();
        return view('admin.alluserlist',compact('data','unreadCountTotal','unreadMessageList'));
    }
    //validation
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:users,email,'.Auth::user()->id,
            'phone' => 'required|unique:users,phone,'.Auth::user()->id,
            'address' => 'required',
            'password' => 'required',
            'image' => 'mimes:png,jpeg,jpg,webp|file'
        ],[
            //validation message
        ])->validate();
    }
    private function getUserData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ];
    }
}
