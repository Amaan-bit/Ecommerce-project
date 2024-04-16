<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AjaxController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\BrandsController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ContactController;
use App\Http\Controllers\frontend\PageController as StaticPageController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\CheckoutController;
use App\Http\Controllers\frontend\AuthController;
use App\Http\Controllers\frontend\MyAccountController;
use App\Http\Controllers\frontend\WishlistController;


// =============Admin Routes=================

Route::group(["middleware"=>'admin.guest',"prefix"=>'admin'],function(){
    Route::get('/login',[LoginController::class,'login'])->name('admin.login');
    Route::post('/login',[LoginController::class,'authenticate'])->name('admin.authenticate');
});

Route::group(["middleware"=>'admin.auth',"prefix"=>'admin'],function(){
    
    Route::get('/logout',[LoginController::class,'logout'])->name('admin.logout');
    Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');

    // ****************Ajax Routes*******************
    Route::post('/get-slug',[AjaxController::class,'GetsLug'])->name('admin.getslug');
    Route::post('/get-subCategory',[AjaxController::class,'GetSubCategory'])->name('get.subcategory');


    // ****************Category Routes****************
    Route::group(['prefix'=>'category'],function(){
        Route::get('/',[CategoryController::class,'index'])->name('admin.category.list');
        Route::get('/create',[CategoryController::class,'create'])->name('admin.category.create');
        Route::post('/store',[CategoryController::class,'store'])->name('admin.category.store');
        Route::get('/edit/{id}',[CategoryController::class,'edit'])->name('admin.category.edit');
        Route::post('/update',[CategoryController::class,'update'])->name('admin.category.update');
        Route::post('/delete',[CategoryController::class,'delete'])->name('admin.category.delete');
    });

    // ****************Sub Category Routes****************
    Route::group(['prefix'=>'subcategory'],function(){
        Route::get('/',[SubCategoryController::class,'index'])->name('admin.subcategory.list');
        Route::get('/create',[SubCategoryController::class,'create'])->name('admin.subcategory.create');
        Route::post('/store',[SubCategoryController::class,'store'])->name('admin.subcategory.store');
        Route::get('/edit/{id}',[SubCategoryController::class,'edit'])->name('admin.subcategory.edit');
        Route::post('/update',[SubCategoryController::class,'update'])->name('admin.subcategory.update');
        Route::post('/delete',[SubCategoryController::class,'delete'])->name('admin.subcategory.delete');
    });

    // ****************Brands Routes****************
    Route::group(['prefix'=>'brands'],function(){
        Route::get('/',[BrandsController::class,'index'])->name('admin.brands.list');
        Route::get('/create',[BrandsController::class,'create'])->name('admin.brands.create');
        Route::post('/store',[BrandsController::class,'store'])->name('admin.brands.store');
        Route::get('/edit/{id}',[BrandsController::class,'edit'])->name('admin.brands.edit');
        Route::post('/update',[BrandsController::class,'update'])->name('admin.brands.update');
        Route::post('/delete',[BrandsController::class,'delete'])->name('admin.brands.delete');
    });

    // ****************Products Routes****************
    Route::group(['prefix'=>'product'],function(){
        Route::get('/',[ProductController::class,'index'])->name('admin.product.list');
        Route::get('/create',[ProductController::class,'create'])->name('admin.product.create');
        Route::post('/store',[ProductController::class,'store'])->name('admin.product.store');
        Route::get('/edit/{id}',[ProductController::class,'edit'])->name('admin.product.edit');
        Route::post('/update',[ProductController::class,'update'])->name('admin.product.update');
        Route::post('/delete',[ProductController::class,'delete'])->name('admin.product.delete');
        Route::get('/gallery/{id}',[ProductController::class,'gallery'])->name('admin.product.gallery');
        Route::post('/add_gallery/{id}/',[ProductController::class,'add_gallery'])->name('admin.product.gallery.add');
        Route::post('/delete_gallery',[ProductController::class,'delete_gallery'])->name('delete.gallery.image');
    });

    // ****************Order Routes****************
    Route::group(['prefix'=>'orders'],function(){
        Route::get('/',[OrderController::class,'index'])->name('admin.order.list');
        Route::get('/detail/{orderId}',[OrderController::class,'order_detail'])->name('admin.order.detail');
        Route::post('/status',[OrderController::class,'order_status'])->name('admin.order.status');
        // Route::get('/edit/{id}',[ProductController::class,'edit'])->name('admin.product.edit');
        // Route::post('/update',[ProductController::class,'update'])->name('admin.product.update');
        // Route::post('/delete',[ProductController::class,'delete'])->name('admin.product.delete');
    });

    // ****************Pages Routes****************
    Route::group(['prefix'=>'pages'],function(){
        Route::get('/',[PageController::class,'index'])->name('admin.page.list');
        Route::get('/create',[PageController::class,'create'])->name('admin.page.create');
        Route::post('/store',[PageController::class,'store'])->name('admin.page.store');
        Route::get('/edit/{id}',[PageController::class,'edit'])->name('admin.page.edit');
        Route::post('/update',[PageController::class,'update'])->name('admin.page.update');
        Route::post('/delete',[PageController::class,'delete'])->name('admin.page.delete');
    });

    // ****************User Routes****************
    Route::group(['prefix'=>'users'],function(){
        Route::get('/',[UserController::class,'index'])->name('admin.user.list');
        Route::get('/create',[UserController::class,'create'])->name('admin.user.create');
        Route::post('/store',[UserController::class,'store'])->name('admin.user.store');
        Route::get('/edit/{id}',[UserController::class,'edit'])->name('admin.user.edit');
        Route::post('/update',[UserController::class,'update'])->name('admin.user.update');
        Route::post('/delete',[UserController::class,'delete'])->name('admin.user.delete');
        Route::get('/export',[UserController::class,'export'])->name('admin.user.export');
    });
    
});

// =======Frontent Routes for users=========
Route::group(["middleware"=>'auth'],function(){

    //****************Checkout Routes****************
    Route::get('/checkout',[CheckoutController::class,'checkout'])->name('front.checkout');
    Route::post('/checkout',[CheckoutController::class,'checkoutProcess'])->name('front.checkout.process');
    Route::get('/success',[CheckoutController::class,'success'])->name('front.paypal.success');
    Route::get('/cancel',[CheckoutController::class,'cancel'])->name('front.paypal.cancel');
    Route::get('/thankYou',[CheckoutController::class,'thankYou'])->name('front.thanx');
    Route::get('/logout',[AuthController::class,'logout'])->name('front.logout');


    //****************Account Routes****************
    Route::get('/my-account',[MyAccountController::class,'account'])->name('front.account');
    Route::post('/my-account',[MyAccountController::class,'update_info'])->name('front.updateInfo');
    Route::get('/my-address',[MyAccountController::class,'myAddress'])->name('front.myaddress');
    Route::post('/my-address',[MyAccountController::class,'updateAddress'])->name('front.updateAddress');
    Route::get('/my-orders',[MyAccountController::class,'myOrders'])->name('front.myorders');
    Route::get('/order-detail/{orderId}',[MyAccountController::class,'orderDetail'])->name('front.orderdetail');
    Route::get('/change-password',[MyAccountController::class,'change_password'])->name('front.changePassword');
    Route::post('/change-password',[MyAccountController::class,'change_password_process'])->name('front.changePasswordProcess');
       
});


    //****************Authentication Routes****************
    Route::get('/google', [AuthController::class, 'redirectToGoogle'])->name('front.google');
    Route::get('/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('front.google.callback');
    Route::get('/facebook', [AuthController::class, 'redirectToFacebook']);
    Route::get('/facebook/callback', [AuthController::class, 'handleFacebookCallback']);
    Route::get('/login',[AuthController::class,'login'])->name('front.login');
    Route::post('/login',[AuthController::class,'authentication'])->name('front.auth');
    Route::get('/register',[AuthController::class,'register'])->name('front.register');
    Route::post('/register',[AuthController::class,'registration'])->name('front.registration');
    Route::get('/forget-password',[AuthController::class,'forget_password'])->name('front.forget');
    Route::post('/email-verify',[AuthController::class,'email_verify'])->name('front.email.verify');
    Route::get('/otp',[AuthController::class,'otp'])->name('front.otp');
    Route::get('/resend-otp/{user_id}',[AuthController::class,'resend_otp'])->name('front.resend.otp');
    Route::post('/otp_verify',[AuthController::class,'otp_verify'])->name('front.otp_verify');
    Route::get('/new-password',[AuthController::class,'new_password'])->name('front.new.password');
    Route::post('/new-password',[AuthController::class,'new_password_process'])->name('front.new.password.process');


    //****************Home Routes****************
    Route::get('/',[HomeController::class,'index'])->name('front.home');
    Route::get('/product/{slug}',[HomeController::class,'product'])->name('front.product');
    Route::get('/shop/{cataegorySlug?}/{subcategorySlug?}/{brandSlug?}',[HomeController::class,'shop'])->name('front.shop');


    //****************Cart Routes****************
    Route::get('/cart',[CartController::class,'cart'])->name('front.cart');
    Route::post('/add-to-cart',[CartController::class,'addToCart'])->name('front.addToCart');
    Route::post('/remove-cart',[CartController::class,'removeCart'])->name('front.removecart');
    Route::post('/update-cart',[CartController::class,'updateCart'])->name('front.updateCart');

    //****************Wishlisr Routes****************
    Route::get('/my-wishlist',[WishlistController::class,'wishlist'])->name('front.wishlist');
    Route::post('/add-wishlist',[WishlistController::class,'addWishlist'])->name('front.addWishlist');
    Route::post('/remove-wishlist',[WishlistController::class,'removeWishlist'])->name('front.removeWishlist');

    //****************Static Pages Routes****************
    Route::get('/contact-us',[ContactController::class,'contact'])->name('front.contact');
    Route::post('/contact',[ContactController::class,'contactData'])->name('front.contact.data');
    Route::get('/{page_slug}',[StaticPageController::class,'pages'])->name('front.page');