<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\subcategory;
use Illuminate\Http\Request;
use Str;
use Image;
class categoryController extends Controller
{
    function category(){
        $categories = category::all();
        $trash_categorys = Category::onlyTrashed()->get();
        return view('admin.users.category.category',[
            'categories' => $categories,
            'trash_category' => $trash_categorys,
        ]);
    }
    function category_store(Request $request){
        $request->validate([
            'category'=>['required','unique:categories,category_name'],
            'category_image'=>['image'],            
        ]);
        if($request->category_image == ''){
            category::insert([
                'category_name' => $request->category,                
            ]);
        }
        else{
            $randomId = rand(10000000,99999999);

            $category_photo = $request->category_image; //img
            $extension = $category_photo->getClientOriginalExtension(); //extension
            $file_name = Str::lower(str_replace(' ','_',$request->category)).'_'.$randomId.'.'.$extension; //category field er nam
            Image::make($category_photo)->save(public_path('uploads/category/'.$file_name));

            category::insert([
                'category_name' => $request->category,       
                'category_image' => $file_name,        
            ]);
        }

        return back()->with('success','Successfully Update Category');
    }
    //Delete Category
    function category_delete($category_id){

        category::find($category_id)->delete();
        return back()->with('category_dlt','Category Deleted Successfully!');
    }
    function category_edit($category_id){
        $category_info = category::find($category_id);
        return view('admin.users.category.edit_category',[
            'category_info'=>$category_info,
        ]);
    }
    function category_update(Request $request){

        if($request->category_image == NULL){
            category::find($request->category_id)->update([
                'category_name'=>$request->category_name,
            ]);
            return back()->with('category_update','Category Updated Successfully!');

        }else{
            //dlt previous img
            $delete_from = Category::find($request->category_id);
            $current_img = public_path('uploads/category/'.$delete_from->category_image);
            unlink($current_img);

            $randomId = rand(10000000,99999999);
            $category_photo = $request->category_image; 
            $extension = $category_photo->getClientOriginalExtension();
            $file_name = Str::lower(str_replace(' ','_',$request->category)).'_'.$randomId.'.'.$extension; //category field er nam
            Image::make($category_photo)->save(public_path('uploads/category/'.$file_name));

            category::find($request->category_id)->update([
                'category_name' => $request->category_name,       
                'category_image' => $file_name, 
            ]);

            return back()->with('category_update','Category Updated Successfully!');
        }
    }

    function category_restor($id){
        category::onlyTrashed()->find($id)->restore();
        return back();
    }

    //permanetn delete category
    function category_dlt($id){

        $delete_from = Category::onlyTrashed()->find($id);
        $current_img = public_path('uploads/category/'.$delete_from->category_image);
        unlink($current_img);

        $subcategories = subcategory::where('category_id', $id)->get();
        
        foreach ($subcategories as $sub) {
            $delete_from = subcategory::find($sub->id);
            $current_img = public_path('uploads/subcategory/'.$delete_from->subcategory_image);
            unlink($current_img);
            subcategory::find($sub->id)->delete();
        }

        Category::onlyTrashed()->find($id)->forceDelete();
        return back()->with('dlt_permanent','Category Deleted Permanently!');

    }

    //Checked All Delete
    function checked_category_dlt(Request $request){
        foreach($request->category_id as $category){
            category::find($category)->delete();
        }
        return back();
    }


    //trash table
    function category_trash(Request $request){
        switch ($request->input('action')) {
            case 'restore':
                foreach($request->category_id as $restore){
                    category::onlyTrashed()->find($restore)->restore();           
                }
                return back();
                break;
            
                case 'delete':                         
                foreach($request->category_id as $delete){
                    category::onlyTrashed()->find($delete)->forceDelete();
                }
                return back();
                break;
        }
    }

}
