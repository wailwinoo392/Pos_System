<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RouteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('webtesting',function(){
    $data = [
        'message' => 'this is api testing message'
    ];
    return response()->json($data, 200);
}); //http://127.0.0.1:8000/api/webtesting
//php artisan make:controller API/RouteController

//user
Route::get('user/list',[RouteController::class,'userList']);//http://127.0.0.1:8000/api/user/list

//product
Route::get('product/list',[RouteController::class,'productList']); //http://127.0.0.1:8000/api/product/list
Route::get('product/delete/{id}',[RouteController::class,'productDelete']);//http://127.0.0.1:8000/api/product/delete
Route::post('admin/product/create',[RouteController::class,'productCreate']); 
//http://127.0.0.1:8000/api/admin/product/create
// body{
//     'productName'
//     'productPrice'
//     'productDescription'
//     'waitingTime'
//     'categoryId'
//     'productImage'
// }
Route::post('admin/product/updated',[RouteController::class,'productUpdate']);
//http://127.0.0.1:8000/api/admin/product/updated
// body{
   //     'productId'
//     'productName'
//     'productPrice'
//     'productDescription'
//     'waitingTime'
//     'categoryId'
//     'productImage'
// }

//categtory
Route::get('category/list',[RouteController::class,'categoryList']);//http://127.0.0.1:8000/api/category/list
Route::post('category/delete',[RouteController::class,'categoryDelete']);//http://127.0.0.1:8000/api/category/delete
Route::post('create/category',[RouteController::class,'createCategory']);
//http://127.0.0.1:8000/api/create/category
// body{
//     name : ''
// }
Route::post('update/category',[RouteController::class,'updateCategory']);
//http://127.0.0.1:8000/api/update/category
// body{
//     'category'=> '',
//     'categoryId' => ''
// }

//message
//user create message or edit message
Route::post('user/create/message',[RouteController::class,'userCreateMessage']);
//http://127.0.0.1:8000/api/user/create/message [post]
// to create = body{
//     'message' : '',
//     'user_id' : ''
// }
// to edit = body{
    //      'editMessageId' : '',
    //     'message' : '',
    //     'user_id' : ''
    // }

//admin create or edit message
Route::post('admin/create/message',[RouteController::class,'adminCreateMessage']);
//http://127.0.0.1:8000/api/admin/create/message [post]
// to create 
// body{
//     'adminId' => '',
//     'userId' =>'',
//     'contactMessage'=>
// }
// to edit 
// body{
//     'editmessageId'=> '',
//     'adminId' => '',
//     'userId' =>'',
//     'contactMessage'=> ''
// }

//message delete
Route::get('message/delete/{id}',[RouteController::class,'messageDelete']);//http://127.0.0.1:8000/api/message/delete/{id}