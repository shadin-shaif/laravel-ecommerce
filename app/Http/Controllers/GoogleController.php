<?php

namespace App\Http\Controllers;

use App\Models\Customerlogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    function google_redirect(){
        return Socialite::driver('google')->redirect();
    }
    function google_callback(){
        $user = Socialite::driver('google')->user();
        // print_r($user);
        if(Customerlogin::where('email', $user->getEmail())->exists()){
             //login user
            if(Auth::guard('customerlogin')->attempt(['email' => $user->getEmail(), 'password' => 'Pa$$w0rd!'])){
                return redirect('/');
            }
        }
        else{
            $customer_id = Customerlogin::insert([
                'name' => $user->getName(),
                'email'=>$user->getEmail(),
                'password'=>bcrypt('Pa$$w0rd!'),
                'created_at'=>Carbon::now(),
            ]);
            
            if(Auth::guard('customerlogin')->attempt(['email' => $user->getEmail(), 'password' => 'Pa$$w0rd!'])){
                return redirect('/');
            }
        }
    }
}
