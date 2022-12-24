<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RattingController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['admin_auth'])->group(function(){
    Route::redirect('/', 'loginPage');
    Route::get('loginPage',[AuthController::class,'logIn'])->name('auth#logInPage');
    Route::get('RegisterPage',[AuthController::class,'register'])->name('auth#registerPage');
});


Route::middleware(['auth'])->group(function(){
    Route::get('dashboard',[AuthController::class,'dashboard']);
    Route::post('product/review',[RattingController::class,'productReview'])->name('product#review');
    Route::get('/user/ajax/review/delete',[AjaxController::class,'reviewDelete']);///user/ajax/review/delete
    Route::get('/adminn/ajax/message/delete',[AjaxController::class,'messageDeleted']);///adminn/ajax/message/delete
    Route::get('user/edit/{id}',[ContactController::class,'adminMessageEdit'])->name('adminMessageEdit');
    //admin
    Route::group(['prefix'=>'adminn','middleware'=>'admin_auth'],function(){
        Route::get('home',[AuthController::class,'adminHome'])->name('admin#home');
        Route::get('profile/edit',[AdminController::class,'adminProfile'])->name('admin#profile');
        Route::post('update',[AdminController::class,'adminUpdate'])->name('admin#update');
        Route::get('password/change/page',[AdminController::class,'adminPasswordChangePage'])->name('admin#passwordChangePage');
        Route::post('password/change',[AdminController::class,'adminPasswordChange'])->name('admin#passwordChange');
        Route::get('all/user/list',[AdminController::class,'adminAllUserList'])->name('admin#allUserList');
        Route::post('user/role',[AdminController::class,'adminUserRole'])->name('admin#userRole');
        Route::prefix('category')->group(function(){
            Route::get('list',[CategoryController::class,'adminCategoryList'])->name('admin#categoryList');
            Route::post('created',[CategoryController::class,'adminCategoryCreate'])->name('admin#categoryCreated');
            Route::get('delete/{id}',[CategoryController::class,'adminCategoryDelete'])->name('admin#categoryDelete');
            Route::post('category/update',[CategoryController::class,'adminCategoryUpdated'])->name('admin#categoryUpdated');
        });
        Route::prefix('product')->group(function(){
            Route::get('list',[ProductController::class,'adminProductList'])->name('admin#productList');
            Route::get('create/page',[ProductController::class,'adminProductCreatePage'])->name('admin#productCreatePage');
            Route::post('create',[ProductController::class,'adminProductCreated'])->name('admin#productCreated');
            Route::get('delete/{id}',[ProductController::class,'adminProductDeleted'])->name('admin#productDeleted');
            Route::get('update/page/{id}',[ProductController::class,'adminProductUpdatePage'])->name('admin#productUpdatePage');
            Route::post('updated',[ProductController::class,'adminProductUpdated'])->name('admin#productUpdated');
        });
        Route::prefix('order')->group(function(){
            Route::get('list',[OrderController::class,'adminOrderList'])->name('admin#orderList');
            Route::post('status',[OrderController::class,'adminOrderStatus'])->name('admin#orderStatus');
            Route::get('detail/{id}',[OrderController::class,'userOrderDetail'])->name('user#orderDetail');
        });
        Route::prefix('ajax')->group(function(){
            Route::get('change/orderStatus',[AjaxController::class,'adminChangeStatus']); ///adminn/ajax/change/orderStatus
            Route::get('changeRole',[AjaxController::class,'adminRolechange']);///adminn/ajax/change/role
            Route::post('secrch/name',[AjaxController::class,'adminNameSearch'])->name('admin#searchName');///adminn/ajax/secrch/name
        });
        Route::prefix('message')->group(function(){
            Route::get('list/{id}',[ContactController::class,'adminMessageList'])->name('admin#messageList');
            Route::post('create',[ContactController::class,'adminMessageCreate'])->name('admin#createMessage');
            Route::get('history/list/{id}',[ContactController::class,'adminMessageHistory'])->name('admin#messageHistory');
            Route::get('all/list',[ContactController::class,'adminMessageAll'])->name('admin#allMessage');
            Route::get('user/delete{id}',[ContactController::class,'adminMessageDelete'])->name('admin#messageDelete');
        });
    });

    //user
    Route::group(['prefix' => 'user','middleware' => 'user_auth'],function(){
        Route::get('home',[AuthController::class,'userHome'])->name('user#home');
        Route::prefix('account')->group(function(){
            Route::get('profile',[UserController::class,'userProfile'])->name('user#accountProfile');
            Route::post('update',[AdminController::class,'adminUpdate'])->name('user#update');
            Route::get('password/change/page',[UserController::class,'userPasswordChangePage'])->name('user#passwordChangePage');
            Route::post('password/change',[AdminController::class,'adminPasswordChange'])->name('user#passwordChange');
        });
        Route::prefix('product')->group(function(){
            Route::get('cart/page',[CartController::class,'userCartPage'])->name('user#cartPage');
            Route::post('review/edit',[RattingController::class,'userReviewEdit'])->name('product#reviewEdit');
            Route::get('detail/{id}',[ProductController::class,'userProductDetail'])->name('user#productDetail');
        });
        Route::prefix('ajax')->group(function(){
            Route::get('add/cart',[AjaxController::class,'addToCart']);//  /user/ajax/order/detail
            Route::get('remove/cart',[AjaxController::class,'removeCart']);
            Route::get('order',[AjaxController::class,'order']);
            Route::get('orderDetail',[AjaxController::class,'orderDetail']);///user/ajax/order/detail
            Route::get('orderSorting',[AjaxController::class,'orderSorting']);///user/ajax/orderSorting
            Route::get('order/category/{id}',[AjaxController::class,'orderCategory'])->name('user#productFilter');///user/ajax/orderCategory
            Route::get('productSearch',[AjaxController::class,'searchProduct']);///user/ajax/product/search
        });
        Route::prefix('order')->group(function(){
            Route::get('history',[OrderController::class,'userOrderHistory'])->name('userOrderHistory');
        });
        Route::prefix('message')->group(function(){
            Route::get('page',[ContactController::class,'messagePage'])->name('user#messagePage');
            Route::post('create',[ContactController::class,'createMessage'])->name('user#createMessage');
        });

    });
});
Route::get('webtesting',function(){
    $data = [
        'message' => 'this is web testing message'
    ];
    return response()->json($data, 200);
}); //http://127.0.0.1:8000/webtesting
