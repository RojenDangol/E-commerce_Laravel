<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index(){
        $items = Cart::instance('cart')->content();
        return view('cart',compact('items'));
    }

    public function add_to_cart(Request $request){
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        return redirect()->back();
    }

    public function increase_cart_quantity($rowId){
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId,$qty);
        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId){
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId,$qty);
        return redirect()->back();
    }

    public function remove_item($rowId){
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }

    public function empty_cart(){
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    public function apply_coupon_code(Request $request){
        $coupon_code = $request->coupon_code;
        if(isset($coupon_code)){
            // dd(Coupon::where('code',$coupon_code)->where('expiry_date','>=',Carbon::today())->where('cart_value','>=',Cart::instance('cart')->subtotal())->first());
            $coupon = Coupon::where('code',$coupon_code)->where('expiry_date','>=',Carbon::today())->where('cart_value','<=',Cart::instance('cart')->subtotal())->first();
            // $coupon= TRUE;
            if(!$coupon){
                return redirect()->back()->with('error','Invalid coupon code!');
            }
            else{
                // dd('jelel');
                Session::put('coupon',[
                    'code'=>$coupon->code,
                    'type'=>$coupon->type,
                    'value'=>$coupon->value,
                    'cart_value'=>$coupon->cart_value,
                ]);
                $this->calculateDiscount();
                return redirect()->back()->with('success','Coupon has been applied!');
            }
        }
        else{
            return redirect()->back()->with('error','Invalid coupon code!');
        }
    }

    public function calculateDiscount(){
        $discount = 0;

        if (Session::has('coupon')) {
            $subtotal = Cart::instance('cart')->subtotal();
            if (!is_numeric($subtotal)) {
                $subtotal = floatval(str_replace(',', '', $subtotal));
            }

            $coupon = Session::get('coupon');
            $couponValue = $coupon['value'];
            if (!is_numeric($couponValue)) {
                $couponValue = floatval($couponValue);
            }

            if ($coupon['type'] == 'fixed') {
                $discount = $couponValue;
            } else {
                $discount = ($subtotal * $couponValue) / 100;
            }

            $subtotalAfterDiscount = $subtotal - $discount;
            $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
            $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

            Session::put('discounts', [
                'discount' => number_format(floatval($discount), 2, '.', ''),
                'subtotal' => number_format(floatval($subtotalAfterDiscount), 2, '.', ''),
                'tax' => number_format(floatval($taxAfterDiscount), 2, '.', ''),
                'total' => number_format(floatval($totalAfterDiscount), 2, '.', ''),
            ]);
        }
    }

}
