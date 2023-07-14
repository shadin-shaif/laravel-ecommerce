<?php

namespace App\Http\Controllers;

use App\Models\brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    function brand(){
        $brand_info = Brand::Paginate(5);
        return view('admin.product.brand',[
            'brands'=>$brand_info,
        ]);
    }
    function brand_store(Request $request){
        $brand_id = brand::insertGetId([
            'brand_name'=>$request->brand_name,
        ]);

        if($request->brand_logo != ''){
            $rand = random_int(10000,99999);
            $brand_logo = $request->brand_logo;
            $extension = $brand_logo->getClientOriginalExtension();
            $file_name = Str::lower(str_replace(' ','-',$request->brand_name)).'-'.$rand.'.'.$extension;
            Image::make($brand_logo)->save(public_path('uploads/brand/'.$file_name));

            brand::find($brand_id)->update([
                'brand_image'=>$file_name,
            ]);
        }

        return back();
    }
}
