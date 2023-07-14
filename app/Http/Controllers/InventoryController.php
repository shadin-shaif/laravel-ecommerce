<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Color;
use App\Models\inventory;
use App\Models\product;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    function variation(){
        $colors = Color::all();
        $categories = category::all();
        $sizes = Size::all();
        return view('admin.product.variation',[
            'colors'=>$colors,
            'categories'=>$categories,
            'sizes'=>$sizes,
        ]);
    }
    function variation_store(Request $request){
        if($request->btn == 1){
            Color::insert([
                'color_name'=>$request->color_name,
                'color_code'=>$request->color_code,
                'created_at'=>Carbon::now(),
            ]);
            return back();
        }
        else{
            Size::insert([
                'size_name'=>$request->size_name,
                'category_id'=>$request->category_id,
                'created_at'=>Carbon::now(),
            ]);
            return back();
        }
    }

    function delete_color($color_id){
        Color::find($color_id)->delete();
        return back()->with('success','Color Deleted Successfully');
    }
    function delete_size($size_id){
        Size::find($size_id)->delete();
        return back()->with('success','Size Deleted Successfully');
    }
    //inventory
    function product_inventory(Request $request){
        $colors = Color::all();
        $product_info = product::find($request->product_id);
        $sizes = Size::where('category_id',$product_info->category_id)->get();
        $inventories = inventory::where('product_id',$request->product_id)->get();
        
        return view('admin.product.inventory',[
            'colors'=>$colors,
            'sizes'=>$sizes,
            'product_info'=>$product_info,
            'inventories'=>$inventories,
        ]);
    }

    function inventory_store(Request $request){
        if(inventory::where('product_id',$request->product_id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->exists()){

            inventory::where('product_id',$request->product_id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->increment('quantity',$request->quantity);
            return back();
        }
        else{
            inventory::insert([
                'product_id'=>$request->product_id,
                'color_id'=>$request->color_id,
                'size_id'=>$request->size_id,
                'quantity'=>$request->quantity,
                'created_at'=> Carbon::now(),
            ]);
            return back();
        }
    }
    function inventory_delete($inventory_id){
        inventory::find($inventory_id)->delete();
        return back();
    }
}
