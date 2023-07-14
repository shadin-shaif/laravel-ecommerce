<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    function cart(Request $request){
        $discount = 0;
        $type = '';
        $mesg = '';

        if($request->coupon_name != ''){
            if(Coupon::where('coupon_name',$request->coupon_name)->exists()){
                if(Carbon::now()->format('Y-m-d') <= Coupon::where('coupon_name',$request->coupon_name)->first()->expire_date){
                    if(Coupon::where('coupon_name',$request->coupon_name)->first()->type == 1){
                        $type = 1;
                        $discount = 21;
                    }
                    else{
                        $type = 2;
                        $discount = 100;
                    }
                }
                else{
                    $discount = 0;
                    $mesg = "Coupon Code Expired";
                }
            }
            else{
                $discount = 0;
                $mesg = "Coupon Code Doesn't Exist";
            }
        }

        $carts = cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.cart',[
            'carts'=>$carts,
            'discount'=>$discount,
            'type'=>$type,
            'mesg'=>$mesg,
        ]);
    }

    function cart_store(Request $request){
        
        if(Auth::guard('customerlogin')->id()){
            if(cart::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id',$request->product_id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->exists()){

                cart::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id',$request->product_id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->increment('quantity',$request->quantity);
                return back()->with('cart_added','Cart Added Successfully');
            }
            else{
                cart::insert([
                    'customer_id'=>Auth::guard('customerlogin')->id(),
                    'product_id'=>$request->product_id,
                    'color_id'=>$request->color_id,
                    'size_id'=>$request->size_id,
                    'quantity'=>$request->quantity,
                    'created_at'=>Carbon::now(),
                ]);
                return back()->with('cart_added','Cart Added Successfully');
            }
        }
        else{
            return redirect()->route('customer_register_login')->withLogin('Plese login to add cart');
        }
    }

    function cart_remove($cart_id){
        cart::find($cart_id)->delete();
        return back();
    }

    function cart_update(Request $request){
        foreach($request->quantity as $cart_id => $quantity){
            cart::find($cart_id)->update([
                'quantity'=>$quantity,
            ]);
        }
        return back();
    }
}
