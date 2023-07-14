<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\category;
use App\Models\Customerlogin;
use App\Models\inventory;
use App\Models\OrderProduct;
use App\Models\product;
use App\Models\productGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Product as StripeProduct;

class FrontendController extends Controller
{
    function index(){
        $categories = category::all();
        $product_info = product::take(12)->get();

        $best_selling = OrderProduct::groupBy('product_id')
        ->selectRaw('sum(quantity) as sum, product_id')
        ->orderBy('sum', 'DESC')->get();
        $new_arrivals = product::latest()->get();

        return view('frontend.index',[
            'categories'=>$categories,
            'product_info'=>$product_info,
            'best_selling'=> $best_selling,
            'new_arrivals'=> $new_arrivals,
        ]);
    }
    function details($slug){

        $product_info = product::where('slug', $slug)->get();
        $product_id = $product_info->first()->id;

        $product_info = product::find($product_id);
        $galleries = productGallery::where('product_id',$product_id)->get();
        $related_products = product::where('category_id',$product_info->category_id)->where('id','!=',$product_id)->get();
        $available_colors = inventory::where('product_id', $product_id)
        ->groupBy('color_id')
        ->selectRaw('count(*) as total, color_id')
        ->get();
        $available_sizes = inventory::where('product_id', $product_id)
        ->groupBy('size_id')
        ->selectRaw('count(*) as total, size_id')
        ->get();
        $reviews = OrderProduct::where('product_id', $product_id)->where('review','!=' ,'NULL')->get();
        $total_review = OrderProduct::where('product_id', $product_id)->where('review','!=' ,'NULL')->count();
        $total_star = OrderProduct::where('product_id', $product_id)->where('review','!=' ,'NULL')->sum('star');
        return view('frontend.details',[
            'product_info'=>$product_info,
            'galleries'=>$galleries,
            'related_products'=>$related_products,
            'available_colors'=>$available_colors,
            'available_sizes'=>$available_sizes,
            'reviews'=>$reviews,
            'total_review'=>$total_review,
            'total_star'=>$total_star,
        ]);
    }

    function get_size(Request $request){
        $sizes = inventory::where('product_id',$request->product_id)->where('color_id', $request->color_id)->get();

        $str = '';

        foreach($sizes as $size){
            if($size->size_id == 1){
                $str = '<div class="form-check size-option form-option form-check-inline mb-2">
                <input checked class="form-check-input" type="radio" name="size_id" id="size'.$size->size_id.'" value="'.$size->size_id.'">
                <label class="form-option-label" for="size'.$size->size_id.'">'.$size->rel_to_size->size_name.'</label>
                </div>';  
            }
            else{
                $str .= '<div class="form-check size-option form-option form-check-inline mb-2">
                <input class="form-check-input" type="radio" name="size_id" id="size'.$size->size_id.'" value="'.$size->size_id.'">
                <label class="form-option-label" for="size'.$size->size_id.'">'.$size->rel_to_size->size_name.'</label>
                </div>';  
            }                                                            
        }
        echo $str;
    }

    function contact_page(){
        return view('frontend.contact');
    }
    function about_page(){
        return view('frontend.about_us');
    }

}
