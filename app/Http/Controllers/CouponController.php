<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    function coupon(){
        $coupons = Coupon::all();
        return view('admin.coupon.coupon',[
            'coupons'=>$coupons,
        ]);
    }
    function coupon_store(Request $request){
        Coupon::insert([
            'coupon_name'=>$request->coupon_name,
            'type'=>$request->type,
            'amount'=>$request->amount,
            'expire_date'=>$request->expire_date,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }

    function coupon_delete($coupon_id){
        Coupon::find($coupon_id)->delete();
        return back();
    }
 
}
