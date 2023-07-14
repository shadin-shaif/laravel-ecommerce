<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Customerlogin;
use App\Models\CustomerVerify;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Notifications\CustomerEmailVerifyNotification;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Illuminate\Support\Facades\Notification;


class CustomerController extends Controller
{
    function customer_reg_login(){
        return view('frontend.customer.register_login');
    }
    //Customer Registration
    function customer_register_store(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|unique:customerlogins|email',
            'password' => 'required|confirmed|min:6'
        ]);
        $customer_id = Customerlogin::insertGetId([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'created_at'=>Carbon::now(),
        ]);
        $customer = Customerlogin::find($customer_id);
        $info = CustomerVerify::create([
            'customer_id'=>$customer_id,
            'token'=>uniqid(),
            'created_ad'=>Carbon::now(),
        ]);

        Notification::send($customer, new CustomerEmailVerifyNotification($info));
        return back()->with('verify','An email verification has been sent to your email. Please verify the email');
    }

    //customer login
    function customer_login(Request $request){
        $request->validate([
            'email'=>['required'],
            'password'=>['required'],
        ]);

       if(Auth::guard('customerlogin')->attempt(['email' => $request->email, 'password' => $request->password])){
            if(Auth::guard('customerlogin')->user()->email_verified_at == null){
                Auth::guard('customerlogin')->logout();
                return back()->with('not_verified','Please, Verify your email first');
            }
            else{
                return redirect('/');
            }
       }
       else{
            return back()->with('wrong','Wrong Credential');
       }
    }

    //customer logout
    function customer_logout(){
        Auth::guard('customerlogin')->logout();
        return redirect('/');
    }
    function customer_profile(){
        return view('frontend.customer.profile');
    }
    
    function customer_update(Request $request){
        if($request->photo == ''){
            if($request->password == ''){
                Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'address'=>$request->address,
                ]);
                return back()->with('success','Profile Info Updated Successfully');
            }
            else{
                //check old pass validation
                if(Hash::check($request->old_password, Auth::guard('customerlogin')->user()->password)){
                    Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'country'=>$request->country,
                        'address'=>$request->address,
                        'password'=>Hash::make($request->password),
                        
                    ]);
                    return back()->with('success','Profile Info Updated Successfully');
                }
                else{
                    return back()->with('old','Current Password Wrong');
                }
            }
        }
        
        //if picture exist
        //if picture exist
        else{
            if($request->password == ''){
                $photo = $request->photo;
                $extension = $photo->getClientOriginalExtension(); 
                $file_name = Auth::guard('customerlogin')->id() . '.'. $extension;
                Image::make($photo)->save(public_path('uploads/customer/'.$file_name));
              
                Customerlogin::find(Auth::guard('customerlogin')->id())->orderBy('created_at', 'DESC')->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'address'=>$request->address,
                    'photo'=>$file_name,
                ]);
                return back()->with('success','Profile Info Updated Successfully');
            }
            else{
                //check old pass validation
                if(Hash::check($request->old_password, Auth::guard('customerlogin')->user()->password)){
                    $photo = $request->photo;
                    $extension = $photo->getClientOriginalExtension(); 
                    $file_name = Auth::guard('customerlogin')->id() . '.'. $extension;
                    Image::make($photo)->save(public_path('uploads/customer/'.$file_name));
                    Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'country'=>$request->country,
                        'address'=>$request->address,
                        'password'=>Hash::make($request->password),
                        
                    ]);
                    return back()->with('success','Profile Info Updated Successfully');
                }
                else{
                    return back()->with('old','Current Password Wrong');
                }
            }
        }
    }
    function my_order(){
        $myorders = Order::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.customer.myorder',[
            'myorders' => $myorders,
        ]);
    }

    //Review
  
    function review_store(Request $request){
        OrderProduct::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->update([
            'star' => $request->rating,
            'review' => $request->review,
        ]);
        return back();
    }
}

