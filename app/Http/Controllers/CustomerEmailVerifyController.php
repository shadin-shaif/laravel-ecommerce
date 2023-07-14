<?php

namespace App\Http\Controllers;

use App\Models\Customerlogin;
use App\Models\CustomerVerify;
use App\Notifications\CustomerEmailVerifyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CustomerEmailVerifyController extends Controller
{
    //Customer Email Verify
    function customer_email_verify($token){
        $customer = CustomerVerify::where('token', $token)->firstOrFail();
        Customerlogin::find($customer->customer_id)->update([
            'email_verified_at'=>Carbon::now(),
        ]);
        return redirect()->route('customer_register_login')->with('verified','Email verified Successfully, Now you can login');
    }
    function email_verify_form(){
        return view('frontend.customer.email_verification_form');
    }
    function email_verify_form_req(Request $request){
        if(Customerlogin::where('email', $request->email)->exists()){
            $customer = Customerlogin::where('email', $request->email)->firstOrFail();
            CustomerVerify::where('customer_id', $customer->id)->delete();
            $info = CustomerVerify::create([
                'customer_id'=>$customer->id,
                'token'=>uniqid(),
                'created_at'=>Carbon::now(),
            ]);
            Notification::send($customer, new CustomerEmailVerifyNotification($info));
            return back()->with('verify','An email verification has been sent to your email. Please verify the email');
        }else{
            return back()->with('wrong','Wrong Credential');
        }
    }
}
