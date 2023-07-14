<?php

namespace App\Http\Controllers;

use App\Models\Customerlogin;
use App\Models\customerPassReset;
use App\Notifications\CustomerPassResetNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CustoemrResetPassController extends Controller
{
    function forgot_password(){
        return view('frontend.customer.reset_password');
    }
    function pass_reset_req_send(Request $request){
        $request->validate([
            'email'=> ['required']
        ]);

        if(Customerlogin::where('email', $request->email)->exists()){
            $customer_info = Customerlogin::where('email',$request->email)->firstOrFail();
            customerPassReset::where('customer_id',$customer_info->id)->delete();
            $info = customerPassReset::create([
                'customer_id'=>$customer_info->id,
                'token'=>uniqid(),
            ]);

            Notification::send($customer_info, new CustomerPassResetNotification($info));
        } 
        else{
            return back()->withInvalid("Email Doesn't Exists");
        }
    }

    function pass_reset_form($token){
        return view('frontend.customer.password_reset_form',[
            'token'=>$token,
        ]);
    }

    function pass_reset_confirm(Request $request){
        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);
        $reset_info = customerPassReset::where('token', $request->token)->firstOrFail();

        Customerlogin::find($reset_info->customer_id)->update([
            'password'=>bcrypt($request->password),
        ]);
        customerPassReset::where('customer_id',$reset_info->customer_id)->delete();
        return back()->withSuccess('Password Reset Successfully.');
    }
}



