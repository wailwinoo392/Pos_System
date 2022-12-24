<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\message;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function messagePage(){
        $maxId = Product::max('review_count');
        $product = Product::whereBetween('review_count',[$maxId-15,$maxId])->orderBy('review_count','desc')->get();
        message::where('user_id',Auth::user()->id)->where('admin_id','>',0)->delete();
        $data = Contact::select('contacts.*','users.name as user_name','users.image','users.gender')
        ->leftjoin('users','users.id','contacts.admin_id')
        ->where('user_id',Auth::user()->id)
        ->orderBy('created_at','desc')
        ->paginate(8);
        // $data = $dat;
        return view('user.contact',compact('data','product'));
    }
    public function createMessage(Request $request){
        if($request->editMessageId){
            message::create([
                'user_id' => Auth::user()->id ,
                'unread_message' => $request->contactMessage
            ]);
            Contact::where('id',$request->editMessageId)->update([
                'message' => $request->contactMessage
            ]);
        }else{
            message::create([
                'user_id' => Auth::user()->id ,
                'unread_message' => $request->contactMessage
            ]);
            Contact::create([
                'user_id' => Auth::user()->id ,
                'message' => $request->contactMessage
            ]);
        }
        $data = message::where('user_id',Auth::user()->id)->select('user_id', DB::raw('SUM(unread_count) as total'))
        ->groupBy('user_id')
        ->get();
        message::where('user_id',$data[0]->user_id)->delete();
        $da = Contact::select('message')->where('user_id',$data[0]->user_id)->latest()->first();
        message::create([
            'user_id' => $data[0]->user_id,
            'unread_count' => $data[0]->total,
            'unread_message' => $da->message
        ]);
        return redirect()->route('user#messagePage');
    }
    public function adminMessageCreate(Request $request){
        if($request->editmessageId){
            Contact::where('id',$request->editmessageId)->update([
                'message' => $request->contactMessage
            ]);
            message::create([
                'admin_id' => Auth::user()->id,
                'user_id' => $request->userId ,
                'unread_message' => $request->contactMessage
            ]);
        }else{
            message::create([
                'admin_id' => Auth::user()->id,
                'user_id' => $request->userId ,
                'unread_message' => $request->contactMessage
            ]);
            Contact::create([
                'admin_id' => Auth::user()->id,
                'user_id' => $request->userId ,
                'message' => $request->contactMessage
            ]);
        }
        $data = message::where('user_id',$request->userId)->select('user_id', DB::raw('SUM(unread_count) as total'))
        ->groupBy('user_id')
        ->get();
        message::where('user_id',$request->userId)->delete();
        $da = Contact::select('message')->where('admin_id',Auth::user()->id)->latest()->first();
        message::create([
            'admin_id'=> Auth::user()->id,
            'user_id' => $request->userId,
            'unread_count' => $data[0]->total,
            'unread_message' => $da->message
        ]);
        if($request->message){
            return redirect()->route('admin#messageHistory',$request->userId);
        }else{
            return redirect()->route('admin#messageList',$request->userId);
        }
    }
    public function adminMessageList($id){
        $unreadList = message::select('messages.*','users.name as user_name','users.image as image','users.gender')
        ->leftjoin('users','users.id','messages.user_id')
        ->where('unread_count','>',0)
        ->where('admin_id', null )
        ->orderBy('created_at','desc')
        ->get();
        $adminList = User::where('role','admin')->get();
        $keys = $adminList->keyBy('id');
        $unreadCountTotal = DB::table('messages')->where('admin_id',null)->sum('unread_count');
        if($unreadCountTotal == 0){
            message::where('unread_count',0)->delete();
        }
        message::where('user_id',$id)
        ->where('admin_id', null )
        ->update([
            'unread_count' => 0
        ]);
        $messageList = Contact::select('contacts.*','users.name as user_name','users.email as email','users.image','users.gender')
        ->leftjoin('users','users.id','contacts.user_id')
        ->where('user_id',$id)
        ->orderBy('created_at','desc')->paginate(5);
        $unreadCountTotal = DB::table('messages')->whereNull('admin_id')->sum('unread_count');
        $unreadMessageList = message::select('messages.*','users.name as user_name')
        ->leftjoin('users','users.id','messages.user_id')
        ->whereNull('messages.admin_id')
        ->orderBy('created_at','desc')
        ->get();
        $unreadCountTotal = DB::table('messages')->whereNull('admin_id')->sum('unread_count');
        return view('admin.messageunreadlist',compact('unreadList','messageList','unreadCountTotal','unreadMessageList','keys'));
    }
    public function adminMessageHistory($id){
        $adminList = User::get();
        $keys = $adminList->keyBy('id');
        $duplicateMessageClient = Contact::select('user_id')
        ->groupBy('user_id')
        ->get();
        foreach($duplicateMessageClient as $item){
            $gg = Contact::where('user_id',$item->user_id)->latest()->first();
            message::create([
                'user_id' => $item->user_id,
                'unread_message' => $gg->message,
                'unread_count'=> 'ASDFREWQPLKJMNB!)@(#*&^$%@('
            ]);
            message::where('user_id',$item->user_id)->update([
                'updated_at' => $gg->created_at
            ]);
        }
        $unreadList = message::select('messages.*','users.name as user_name','users.image','users.gender')
        ->leftjoin('users','users.id','messages.user_id')
        ->where('unread_count','ASDFREWQPLKJMNB!)@(#*&^$%@(')
        ->orderBy('updated_at','desc')
        ->paginate(7);
        message::where('unread_count','ASDFREWQPLKJMNB!)@(#*&^$%@(')->delete();
        $unreadMessageList = message::select('messages.*','users.name as user_name')
        ->leftjoin('users','users.id','messages.user_id')
        ->whereNull('messages.admin_id')
        ->orderBy('created_at','desc')
        ->get();
        $message = Contact::select('contacts.*','users.name as user_name','users.email as email','users.image','users.gender')
        ->leftjoin('users','users.id','contacts.user_id');
        $unreadCountTotal = DB::table('messages')->whereNull('admin_id')->sum('unread_count');
        $messageList = $message->where('user_id',$id)
        ->orderBy('created_at','desc')->paginate(5);
        return view('admin.adminmessagehistory',compact('id','unreadList','messageList','unreadCountTotal','unreadMessageList','keys'));
    }
    public function adminMessageAll(){
        $duplicateMessageClient = Contact::select('user_id')
        ->groupBy('user_id')
        ->get();
        foreach($duplicateMessageClient as $item){
            $gg = Contact::where('user_id',$item->user_id)->latest()->first();
            message::create([
                'user_id' => $item->user_id,
                'unread_message' => $gg->message,
                'unread_count'=> 'ASDFREWQPLKJMNB!)@(#*&^$%@('
            ]);
            message::where('user_id',$item->user_id)->update([
                'updated_at' => $gg->created_at
            ]);
        }
        $unreadList = message::select('messages.*','users.name as user_name','users.image','users.gender')
        ->leftjoin('users','users.id','messages.user_id')
        ->where('unread_count','ASDFREWQPLKJMNB!)@(#*&^$%@(')
        ->orderBy('updated_at','desc')
        ->paginate(7);
        message::where('unread_count','ASDFREWQPLKJMNB!)@(#*&^$%@(')->delete();
        $unreadMessageList = message::select('messages.*','users.name as user_name')
        ->leftjoin('users','users.id','messages.user_id')
        ->whereNull('messages.admin_id')
        ->orderBy('created_at','desc')
        ->get();
        $unreadCountTotal = DB::table('messages')->whereNull('admin_id')->sum('unread_count');
        return view('admin.messagealllist',compact('unreadList','unreadCountTotal','unreadMessageList'));
    }
    public function adminMessageDelete($id){
        Contact::where('user_id',$id)->delete();
        return redirect()->route('admin#allMessage');
    }
}
