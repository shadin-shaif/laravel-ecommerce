<?php

namespace App\Http\Controllers;

use App\Models\brand;
use App\Models\category;
use App\Models\Color;
use App\Models\product;
use App\Models\Size;
use Illuminate\Http\Request;

class ShopPageController extends Controller
{


    function shop_page(Request $request){
        $data = $request->all();
        $sorting = 'created_at';
        $type = 'DESC';
        if(!empty($data['sort']) && $data['sort'] != '' && $data['sort'] != 'undefined'){
            if($data['sort'] == 1){
                $sorting = 'product_name';
                $type = 'ASC';
            }else if($data['sort'] == 2){
                $sorting = 'product_name';
                $type = 'DESC';
            }else if($data['sort'] == 3){
                $sorting = 'after_discount';
                $type = 'ASC';
            }else if($data['sort'] == 4){
                $sorting = 'after_discount';
                $type = 'DESC';
            }
        }

        $categorys = category::all();
        //searching product
        $products = product::where(function($q) use ($data){ //get the val of url and pass on $q
            //Search using name
            if(!empty($data['q']) && $data['q'] != '' && $data['q'] != 'undefined'){
                $q->where(function($q) use ($data){
                    $q->where('product_name','like','%'.$data['q'].'%');
                    $q->orWhere('long_desp','like','%'.$data['q'].'%');
                });
            }
            //search using price range
            $min = 0;
            if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined'){
                $min = $data['min'];
            }
            else{
                $min = 1;
            }

            $max = 0;
            if(!empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined'){
                $max = $data['max'];
            }
            else{
                $max = 10000000;
            }
            if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined' || !empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined'){
                $q->whereBetween('after_discount',[$min, $max]);
            }
            //category
            if(!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id'] != 'undefined'){
                $q->where('category_id',$data['category_id']);
            }
            //Brand
            if(!empty($data['b']) && $data['b'] != '' && $data['b'] != 'undefined'){
                $q->where('brand',$data['b']);
            }
            
            //Color
            if(!empty($data['color']) && $data['color'] != '' && $data['color'] != 'undefined' || !empty($data['size']) && $data['size'] != '' && $data['size'] != 'undefined'){
                $q->whereHas('rel_to_inventory', function($q) use ($data){
                    if(!empty($data['color']) && $data['color'] != '' && $data['color'] != 'undefined'){
                        $q->whereHas('rel_to_color', function($q) use ($data){
                            $q->where('colors.id', $data['color']);
                        });
                    }
                    if(!empty($data['size']) && $data['size'] != '' && $data['color'] != 'undefined'){
                        $q->whereHas('rel_to_size', function($q) use ($data){
                            $q->where('sizes.id', $data['size']);
                        });
                    }
                });
            }
        })->orderBy($sorting, $type)->get();

        $brands = brand::all();
        $colors = Color::whereNotNull('color_code')->get();
        $sizes = Size::all();
        return view('frontend.shop_page',[
            'products' => $products,
            'categorys' => $categorys,
            'brands' => $brands,
            'colors' => $colors,
            'sizes' => $sizes,
            
        ]);
    }
}
