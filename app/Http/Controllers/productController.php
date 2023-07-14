<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\product;
use App\Models\category;
use App\Models\productGallery;
use App\Models\subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Carbon;

class productController extends Controller
{
    function add_product(){
        $categories = category::all();
        $subcategories = subcategory::all();
        $brand = brand::all();
        return view('admin.product.add_product',[
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'brands'=>$brand,
        ]);
    }
    //ajax request
    //ajax request
    function getsubcategory(Request $request){
        $subcategories = subcategory::where('category_id',$request->category_id)->get();
        $str = '<option value="">-- Select Any -- </option>';

        foreach($subcategories as $subcategory){
            $str .= '<option value="'.$subcategory->id . '">'.$subcategory->subcategory_name . '</option>'; 
        }
        echo $str;
    }
    //store product details
    function product_store(Request $request){
        $rand2 = random_int(1000000,9999999);
        $slug = Str::lower(str_replace(' ','-',$request->product_name)).'-'.$rand2;
        $rand = random_int(10000,99999);
        $sku = Str::upper(substr($request->product_name, 0,1)).'-'.$rand;

        $product_id = product::insertGetId([
            'product_name'=>$request->product_name,
            'price'=>$request->price,
            'discount'=>$request->discount,
            'after_discount'=>$request->price - ($request->price*$request->discount)/100,
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'brand'=>$request->brand,
            'short_desp'=>$request->short_description,
            'long_desp'=>$request->long_description,
            'additional_info'=>$request->additional_info, 
            'sku'=>$sku,
            'slug'=>$slug, 
            'created_at'=>Carbon::now(),
        ]);

        $preview_img = $request->preview;
        $extension = $preview_img->getClientOriginalExtension();
        $file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.$rand2.'.'.$extension;
        Image::make($preview_img)->save(public_path('uploads/product/preview/'.$file_name));

        product::find($product_id)->update([
            'preview'=>$file_name,
        ]);


        //Product Gallery
        $gallery_image = $request->gallery;

        if($gallery_image != ''){
            foreach($gallery_image as $gallery){

                $rand2 = random_int(1000000,9999999);
                $gallery_extension = $gallery->getClientOriginalExtension();
                $gallery_file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.$rand2.'.'.$gallery_extension;
    
                Image::make($gallery)->save(public_path('uploads/product/gallery/'.$gallery_file_name));
    
                productGallery::insert([
                    'product_id'=> $product_id,
                    'gallery'=> $gallery_file_name,
                    'created_at'=>Carbon::now(),
                ]);
            }
        }
        return back();
    }

    // Show Product List
    function product_list(){
        $all_products= product::all();
        return view('admin.product.product_list',[
            "all_products" => $all_products, 
        ]);
    }
    //product view/edit/delete
    function product_edit(Request $request){
        $product_info = product::find($request->product_id);
        $gallery_imges = productGallery::where('product_id',$request->product_id)->get();
        $categories = category::all();
        $subcategories = subcategory::all();
        $brands = brand::all();
        return view('admin.product.edit_product',[
            'product_info'=>$product_info,
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'brands'=>$brands,
            'gallery_imges'=> $gallery_imges,
        ]);
    }



    function product_delete($product_id){
        // $preview = product::find($product_id);
        // $delete_form = public_path('uploads/product/preview/'.$preview->preview);
        // unlink($delete_form);
        // product::find($product_id)->delete();
        //gallery dlt


        // return 'back()';
    }


    function product_update(Request $request){
        $rand2 = random_int(1000000,9999999);

        if($request->preview == ''){
            if($request->gallery == ''){
                //Preview & gallery empty
                product::find($request->product_id)->update([
                    'product_name'=>$request->product_name,
                    'price'=>$request->price,
                    'discount'=>$request->discount,
                    'after_discount'=>$request->price - ($request->price*$request->discount)/100,
                    'category_id'=>$request->category_id,
                    'subcategory_id'=>$request->subcategory_id,
                    'brand'=>$request->brand,
                    'short_desp'=>$request->short_description,
                    'long_desp'=>$request->long_description,
                    'additional_info'=>$request->additional_info, 
                    'created_at'=>Carbon::now(),
                ]);
            }
            else{
                ## Preview empty but gallery ache

                $present_gallery = productGallery::where('product_id',$request->product_id)->get();
                foreach($present_gallery as $gal){
                    $delete_form = public_path('uploads/product/gallery/'.$gal->gallery);
                    unlink($delete_form);

                    productGallery::where('product_id',$gal->product_id)->delete();
                }

                $gallery_image = $request->gallery;
                foreach($gallery_image as $gallery){                    
                    $gallery_extension = $gallery->getClientOriginalExtension();
                    $gallery_file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.$rand2.'.'.$gallery_extension;
        
                    Image::make($gallery)->save(public_path('uploads/product/gallery/'.$gallery_file_name));
        
                    productGallery::insert([
                        'product_id'=> $request->product_id,
                        'gallery'=> $gallery_file_name,
                        'created_at'=>Carbon::now(),
                    ]);
                }
            }
        }
        else{
            //Preview available
            if($request->gallery == ''){
                //Preview available but gallery empty
                $prev_img = product::find($request->product_id);
                $delete_form = public_path('uploads/product/preview/'.$prev_img->preview);
                unlink($delete_form);

                $preview_img = $request->preview;
                $extension = $preview_img->getClientOriginalExtension();
                $file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.$rand2.'.'.$extension;
                Image::make($preview_img)->save(public_path('uploads/product/preview/'.$file_name));
        
                product::find($request->product_id)->update([
                    'product_name'=>$request->product_name,
                    'price'=>$request->price,
                    'discount'=>$request->discount,
                    'after_discount'=>$request->price - ($request->price*$request->discount)/100,
                    'category_id'=>$request->category_id,
                    'subcategory_id'=>$request->subcategory_id,
                    'brand'=>$request->brand,
                    'short_desp'=>$request->short_description,
                    'long_desp'=>$request->long_description,
                    'additional_info'=>$request->additional_info, 
                    'preview'=>$file_name,
                    'created_at'=>Carbon::now(),
                ]);
            }
            else{
            //Preview & gallery available    
                $present_gallery = productGallery::where('product_id',$request->product_id)->get();
                foreach($present_gallery as $gal){
                    $delete_form = public_path('uploads/product/gallery'.$gal->gallery);
                    unlink($delete_form);

                    productGallery::where('product_id',$gal->product_id)->delete();
                }

                $gallery_image = $request->gallery;
                foreach($gallery_image as $gallery){                    
                    $gallery_extension = $gallery->getClientOriginalExtension();
                    $gallery_file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.$rand2.'.'.$gallery_extension;
        
                    Image::make($gallery)->save(public_path('uploads/product/gallery/'.$gallery_file_name));
        
                    productGallery::insert([
                        'product_id'=> $request->product_id,
                        'gallery'=> $gallery_file_name,
                        'created_at'=>Carbon::now(),
                    ]);
                }
                //preview img
                $prev_img = product::find($request->product_id);
                $delete_form = public_path('uploads/product/preview'.$prev_img->preview);
                unlink($delete_form);

                $preview_img = $request->preview;
                $extension = $preview_img->getClientOriginalExtension();
                $file_name = Str::lower(str_replace(' ','-',$request->product_name)).'-'.$rand2.'.'.$extension;
                Image::make($preview_img)->save(public_path('uploads/product/preview/'.$file_name));


                product::find($request->product_id)->update([
                    'product_name'=>$request->product_name,
                    'price'=>$request->price,
                    'discount'=>$request->discount,
                    'after_discount'=>$request->price - ($request->price*$request->discount)/100,
                    'category_id'=>$request->category_id,
                    'subcategory_id'=>$request->subcategory_id,
                    'brand'=>$request->brand,
                    'short_desp'=>$request->short_description,
                    'long_desp'=>$request->long_description,
                    'additional_info'=>$request->additional_info, 
                    'preview'=>$file_name,
                    'created_at'=>Carbon::now(),
                ]);
            }
        }
        return back();
    }

}
