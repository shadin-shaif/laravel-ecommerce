<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SubCategoryController extends Controller
{
    function subcategory(){
        $categories = category::all();
        $subcategory = subcategory::all();
        return view('admin.users.category.subcategory',[
            'categories'=>$categories,
            'subcategory'=>$subcategory,
        ]);
    }


#================

    function subcategory_store(Request $request){

        if($request->subcategory_image != NULL){
            $subcategory_image = $request->subcategory_image;

            $extension = $subcategory_image->getClientOriginalExtension();
            $file_name = Str::lower(str_replace(' ','_',$request->subcategory)).'.'.$extension;
            Image::make($subcategory_image)->save(public_path('uploads/subcategory/'.$file_name));
            subcategory::insert([
                'subcategory_name'=>$request->subcategory,
                'category_id'=>$request->category_id,
                'subcategory_image'=>$file_name,
                
            ]);
            return back();
        }

        else{
                subcategory::insert([
                'subcategory_name'=>$request->subcategory,
                'category_id'=>$request->category_id,
            ]);
            return back();
        }
    }





    function subcategory_edit($subcategory_id){
        $categories = category::all();
        $subcategory_info = subcategory::find($subcategory_id);
        return view('admin.users.category.subcategory_edit',[
            'categories'=>$categories,
            'subcategory_info'=>$subcategory_info,
        ]);
    }

    function subcategory_update(Request $request){
        echo $request->id;
        if($request->subcategory_image == NULL){
            subcategory::find($request->id)->update([
                'subcategory_name'=>$request->subcategory,
                'category_id'=>$request->category_id,
            ]);
            return back();
        }
        else{
            $subcategory_image = $request->subcategory_image;

            $extension = $subcategory_image->getClientOriginalExtension();
            $file_name = Str::lower(str_replace(' ','_',$request->subcategory)).'.'.$extension;
            Image::make($subcategory_image)->save(public_path('uploads/subcategory/'.$file_name));
 
            subcategory::find($request->id)->update([
                'subcategory_name'=>$request->subcategory,
                'category_id'=>$request->category_id,
                'subcategory_image'=>$file_name,
            ]);
            return back();
        }
    }



    ///need some help to unlink the image
    function subcategory_delete($subcategory_id){
        subcategory::find($subcategory_id)->delete();
        // unlink(public_path('uploads/subcategory/'.subcategory::all()->subcategory_image));
        return back()->with('success','Deleted Successfully!');
    }
}