<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\userPassUpdate;
use Illuminate\Auth\Events\Validated;
use Illuminate\Validation\Rules\Password;
use Faker\Provider\Image;
use make;

class UserController extends Controller
{
    function users(){
        $users = User::where('id', '!=', Auth::id())->get();
        $total_user = User::count();
        return view('admin.users.users', compact('users','total_user'));
    }
    function delete_user($user_id){
        User::find($user_id)->delete();
        return back()->with('success','User Deleted!');
    }
    public function user_edit(){
        return view('admin.users.edit_profile');
    }
    public function user_profile_update(Request $request){
        User::find(Auth::id())->update([
            'name'=>$request->name,
            'email'=>$request->email,
        ]);
        return back()->with('success','Update successfully!');
    }
    function user_update_password(userPassUpdate $request){
    
      if(Hash::check($request->old_password, Auth::user()->password)){
        User::find(Auth::id())->update([
            'password'=>bcrypt($request->password),
        ]);
        return back()->with('pass_update','Password Updated Successfully!');
      }
      else{
        return back()->with('wrong_pass','Wrong Password!');
      }
    }



    
    function user_photo_update(Request $request){
        $request->validate([
            'photo'=>['required','mimes:jpg,png,jpeg'],
            'photo' => 'file|max:912'
        ]);

        if(Auth::user()->photo != NULL){
            unlink(public_path('uploads/user/'.Auth::user()->photo));
        }
        
        $uploaded_photo = $request->photo;
        $extension = $uploaded_photo->getClientOriginalExtension();
        $file_name = Auth::id().'.'.$extension;
        Image::make($uploaded_photo)->save(public_path('uploads/user/'.$file_name));

        User::find(Auth::id())->update([
            'photo'=>$file_name,
        ]);
        return back()->with('img_success','Successfully Updated!');

    }

}

    