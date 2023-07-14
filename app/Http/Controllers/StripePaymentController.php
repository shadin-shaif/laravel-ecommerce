<?php
    
namespace App\Http\Controllers;
     
use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Mail\OrderInvoice;
use App\Models\BillingDetails;
use App\Models\cart;
use App\Models\City;
use App\Models\Order;
use App\Models\Country;
use App\Models\inventory;
use App\Models\OrderProduct;
use App\Models\ShippingDetails;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;     
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }
    
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $data = session('info');
        $total = $data['sub_total'] + $data['charge'];

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([
                "amount" => $total * 100,
                "currency" => "BDT",
                "source" => $request->stripeToken,
                "description" => "Test payment from PICABOBD." 
        ]);
      
        Session::flash('success', 'Payment successful!');
              

        //insert data on order table
        $city = City::find($data['city_id']);
        $rand = random_int(100000,999999);
        $order_id = '#'.Str::upper(substr($city->name, 0, 3)).'-'.$rand;
        $customer_id = Auth::guard('customerlogin')->id();

        
        Order::insert([
            'order_id'=> $order_id,
            'customer_id'=> $customer_id,
            'subtotal'=> $data['sub_total'],
            'charge'=> $data['charge'],
            'discount'=> $data['discount'],
            'total'=> $total,
            'payment_method'=> $data['payment_method'],
            'created_at'=> Carbon::now(),
        ]);

        BillingDetails::insert([
            'order_id'=> $order_id,
            'customer_id'=> $customer_id,
            'name'=> Auth::guard('customerlogin')->user()->name,
            'email'=> Auth::guard('customerlogin')->user()->email,
            'mobile'=> $data['billing_phone'],
            'company'=> $data['company'],
            'address'=> Auth::guard('customerlogin')->user()->address,
            'created_at'=>Carbon::now(),
        ]);

        ShippingDetails::insert([
            'order_id'=> $order_id,
            'name'=> $data['name'],
            'email'=> $data['shipping_email'],
            'mobile'=> $data['shipping_mobile'],
            'country_id'=> $data['country_id'],
            'city_id'=> $data['city_id'],
            'address'=> $data['address'],
            'zip'=> $data['zip'],
            'notes'=> $data['notes'],
            'created_at'=>Carbon::now(),
        ]);

        $carts = cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        foreach($carts as $cart){
            OrderProduct::insert([
                'order_id'=> $order_id,
                'customer_id'=> $customer_id,
                'product_id'=> $cart->product_id,
                'price'=> $cart->rel_to_product->after_discount,
                'color_id'=> $cart->color_id,
                'size_id'=> $cart->size_id,
                'quantity'=> $cart->quantity,
                'created_at'=> Carbon::now(),

            ]);

            inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
            //delete cart item
            cart::find($cart->id)->delete();
        }

        //mail sending after order
        $mail = Auth::guard('customerlogin')->user()->email;
        Mail::to($mail)->send(new OrderInvoice($order_id));
        //send SMS
        $total = $total;
        // $url = "http://bulksmsbd.net/api/smsapi";
        // $api_key = "wzm9wcY9M3IHYvlY65SZ";
        // $senderid = "alamin123";
        // $number = "$request->billing_phone";
        // $message = "Congratulations, Your order has been placed. Thank you for shopping with us. Please ready Tk".$total;
        
        // $data = [
        //     "api_key" => $api_key,
        //     "senderid" => $senderid,
        //     "number" => $number,
        //     "message" => $message
        // ];
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // $response = curl_exec($ch);
        // curl_close($ch);


        // $url = "http://66.45.237.70/api.php";
        // $number="$request->billing_phone";
        // $text="Congratulations, Your order has been placed. Thank you for shopping with us. Please ready Tk " .$total;
        // $data= array(
        // 'username'=>"01834833973",
        // 'password'=>"TE47RSDM",
        // 'number'=>"$number",
        // 'message'=>"$text"
        // );

        // $ch = curl_init(); // Initialize cURL
        // curl_setopt($ch, CURLOPT_URL,$url);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $smsresult = curl_exec($ch);
        // $p = explode("|",$smsresult);
        // $sendstatus = $p[0];


        $order_id = substr($order_id,1);
        return redirect()->route('order.success', $order_id)->withOrdersuccess('Order Succed!');
        
    }
}


