<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustoemrResetPassController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerEmailVerifyController;
use App\Http\Controllers\FacebookController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\productController;
use App\Http\Controllers\ShadinController;
use App\Http\Controllers\ShopPageController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\SubCategoryController;
use App\Models\subcategory;

//FrontendController
Route::get('/',[FrontendController::class,'index'])->name('index');
Route::get('/product/details/{slug}',[FrontendController::class,'details'])->name('details');
Route::post('/getsize',[FrontendController::class,'get_size']);

//cartController
Route::get('/cart',[CartController::class,'cart'])->name('cart');
Route::post('/cart/store',[CartController::class,'cart_store'])->name('cart.store');
Route::get('/cart/remove/{cart_id}',[CartController::class,'cart_remove'])->name('cart.remove');
Route::post('/cart/update',[CartController::class,'cart_update'])->name('cart.update');

//CheckoutController
Route::get('/checkout',[CheckoutController::class,'checkout'])->name('checkout');
Route::post('/getcity',[CheckoutController::class,'get_city']);
Route::post('/order/store',[CheckoutController::class,'order_store'])->name('order.store');
Route::get('/order/success/{order_id}',[CheckoutController::class,'order_success'])->name('order.success');

//admin 
Auth::routes();
Route::get('/admin/logout', [HomeController::class, 'admin_logout'])->name('admin.logout');
Route::get('/home', [HomeController::class, 'index'])->name('home');

//CouponController
Route::get('/coupon',[CouponController::class,'coupon'])->name('coupon');
Route::post('/coupon/store',[CouponController::class,'coupon_store'])->name('coupon.store');
Route::get('/coupon/delete/{coupon_id}',[CouponController::class,'coupon_delete'])->name('coupon.delete');

//User
Route::get('/users', [UserController::class, 'users'])->name('users');
// Delete user
Route::get('/user/delete/{user_id}',[UserController::class, 'delete_user'])->name('delete.user');
Route::get('/user/edit',[UserController::class,'user_edit'])->name('user.edit');
Route::post('/user/profile/update',[UserController::class,'user_profile_update'])->name('update.profile.info');
Route::post('/user/password/update',[UserController::class,'user_update_password'])->name('update.password');

//image
Route::post('/user/photo/update',[UserController::class,'user_photo_update'])->name('update.photo');


//Catagory
Route::get('/category',[categoryController::class,'category'])->name('category');
Route::post('/category/store',[categoryController::class,'category_store'])->name('category.store');
Route::get('/category/delete/{category_id}',[categoryController::class,'category_delete'])->name('category.delete');
Route::get('/category/edit/{category_id}',[categoryController::class,'category_edit'])->name('category.edit');
Route::post('/category/update',[categoryController::class,'category_update'])->name('category.update');
Route::get('/category/restor/{id}',[categoryController::class,'category_restor'])->name('category.restor');
Route::get('/category/category_dlt/{id}',[categoryController::class,'category_dlt'])->name('category.dlt');
Route::post('/category/checked/delete',[categoryController::class,'checked_category_dlt'])->name('check.delete');

//Trash 
Route::post('/category/trash',[categoryController::class,'category_trash'])->name('category.trash');

//SubCategory
Route::get('/subcategory',[SubCategoryController::class,'subcategory'])->name('subcategory');
Route::post('/subcategory/store',[SubCategoryController::class,'subcategory_store'])->name('subcategory.store');
Route::get('/subcategory/edit{subcategory_id}',[SubCategoryController::class,'subcategory_edit'])->name('subcategory.edit');
Route::get('/subcategory/delete{subcategory_id}',[SubCategoryController::class,'subcategory_delete'])->name('subcategory.delete');
Route::post('/subcategory/update',[SubCategoryController::class,'subcategory_update'])->name('subcategory.update');

//Product
Route::get('/add/product',[productController::class,'add_product'])->name('add.product');
Route::post('/getsubcategory',[productController::class,'getsubcategory']);
Route::post('/product/store',[productController::class,'product_store'])->name('product.store');

//Product Brand
Route::get('/brand',[BrandController::class,'brand'])->name('brand');
Route::post('/brand/store',[BrandController::class,'brand_store'])->name('brand.store');

//Product List
Route::get('/product/list',[productController::class,'product_list'])->name('product.list');

Route::get('/product/edit',[productController::class,'product_edit'])->name('product.edit');
Route::get('/product/delete/{product_id}',[productController::class,'product_delete'])->name('product.delete');
Route::post('/product/update',[productController::class,'product_update'])->name('product.update');

//variation
Route::get('/inventory',[InventoryController::class,'variation'])->name('variation');
Route::post('/variation/store',[InventoryController::class,'variation_store'])->name('variation.store');
Route::get('/color/delete/{color_id}',[InventoryController::class,'delete_color'])->name('delete.color');
Route::get('/size/delete/{size_id}',[InventoryController::class,'delete_size'])->name('delete.size');
//inventory
Route::get('/product/inventory',[InventoryController::class,'product_inventory'])->name('product.inventory');
Route::post('inventory/store',[InventoryController::class,'inventory_store'])->name('inventory.store');
Route::get('/inventory/delete/{inventory_id}',[InventoryController::class,'inventory_delete'])->name('inventory.delete');

//customer details
Route::get('/customer-reg-login',[CustomerController::class,'customer_reg_login'])->name('customer_register_login');
Route::post('/customer/register/store',[CustomerController::class,'customer_register_store'])->name('customer.register.store');
Route::post('/customer/login',[CustomerController::class,'customer_login'])->name('customer.login');
Route::get('/customer/logout',[CustomerController::class,'customer_logout'])->name('customer.logout');
Route::get('/customer/profile',[CustomerController::class,'customer_profile'])->name('customer.profile');
Route::post('/customer/update',[CustomerController::class,'customer_update'])->name('customer.update');
Route::get('/myorder',[CustomerController::class,'my_order'])->name('myorder');

//OrderController
Route::get('/orders',[OrderController::class,'orders'])->name('orders');
Route::post('/order/status',[OrderController::class,'order_status'])->name('status.update');
Route::get('/download/invoice/{order_id}',[OrderController::class,'download_invoice'])->name('download.invoice');

// SSLCOMMERZ Start

Route::get('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

#stripe
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});

//Review
Route::post('/review', [CustomerController::class, 'review_store'])->name('review.store');

//customer password reset
Route::get('/forgot/password',[CustoemrResetPassController::class,'forgot_password'])->name('forgot.password');
Route::post('/pass/reset/request/send',[CustoemrResetPassController::class,'pass_reset_req_send'])->name('pass.reset.req.send');
Route::get('/pass/reset/form/{token}',[CustoemrResetPassController::class,'pass_reset_form'])->name('pass.reset.form');
route::post('pass/reset/confirm',[CustoemrResetPassController::class,'pass_reset_confirm'])->name('pass.reset.confirm');


//Customer email verify
Route::get('/customer/email/verify/{token}',[CustomerEmailVerifyController::class,'customer_email_verify'])->name('customer.email.verify');
Route::get('/email/verify/form',[CustomerEmailVerifyController::class,'email_verify_form'])->name('email.verify.form');
Route::post('email/verify/request',[CustomerEmailVerifyController::class,'email_verify_form_req'])->name('email.verify.form.req');

//Shop page and product searchin
Route::get('/shop',[ShopPageController::class,'shop_page'])->name('shoppage');
// Route::get('/search',[ShopPageController::class,'search'])->name('search');

//Contact Page
Route::get('/contact', [FrontendController::class,'contact_page'])->name('contact');
Route::get('/about_us', [FrontendController::class,'about_page'])->name('about.us');

//Socail Login
Route::get('/github/redirect', [GithubController::class,'github_redirect'])->name('github.redirect');
Route::get('/github/callback-url ', [GithubController::class,'github_callback'])->name('github.callback');
Route::get('/google/redirect', [GoogleController::class,'google_redirect'])->name('google.redirect');
Route::get('/google/callback-url ', [GoogleController::class,'google_callback'])->name('google.callback');
Route::get('/facebook/redirect', [FacebookController::class,'facebook_redirect'])->name('facebook.redirect');
Route::get('/facebook/callback-url ', [FacebookController::class,'facebook_callback'])->name('facebook.callback');


