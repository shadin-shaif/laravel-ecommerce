<?php

namespace App\Http\Controllers;

use App\Models\Customerlogin;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class OrderController extends Controller
{
    function orders(){
        $orders = Order::all();
        return view('admin.orders.orders',[
            'orders'=> $orders,
        ]);
    }

    function order_status(Request $request){
        Order::where('order_id', $request->order_id)->update([
            'status'=>$request->status,
        ]);
        return back();
    }

    function download_invoice($order_id){
        $info = Order::find($order_id);
        $order_id = $info->order_id;

        $pdf = PDF::loadView('frontend.customer.invoice_pdf',[
            'order_id'=>$order_id,
        ]);
        return $pdf->download('invoice.pdf');
    }
}
