<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function orders(){
        $orders = Order::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(10);
        return view('user.orders',compact('orders'));
    }

    public function order_details($order_id){
        $order = Order::where('user_id',Auth::user()->id)->where('id',$order_id)->first();
        if($order){
            $orderItems = OrderItem::where('order_id',$order->id)->orderBy('id')->paginate(12);
            $transaction = Transaction::where('order_id',$order->id)->first();
            return view('user.order-details',compact('order','orderItems','transaction'));
        }
        else{
            return redirect()->route('login');
        }
    }

    public function order_cancel(Request $request){
        $order = Order::find($request->order_id);
        $order->status = 'canceled';
        $order->canceled_date = Carbon::now();
        $order->save();
        return back()->with('status','Order has been canceled!');
    }

    public function address(){
        $address = Address::where('user_id',Auth::user()->id)->first();
        return view('user.account-address',compact('address'));
    }

    public function edit_address($id){
        $address = Address::where('id',$id)->first();
        return view('user.address-edit',compact('address'));
    }

    public function update_address(Request $request){
        $request->validate([
            'name'=>'required|max:100',
            'phone'=>'required|numeric|digits:10',
            'locality'=>'required',
            'city'=>'required',
            'state'=>'required',
            'landmark'=>'required',
            'address'=>'required',
            'zip'=>'required|numeric|digits:6',
            'isdefault'=>'required',
        ]);
        $address=Address::find($request->id);
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->locality = $request->locality;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->landmark = $request->landmark;
        $address->address = $request->address;
        $address->zip = $request->zip;
        $address->isdefault = $request->isdefault;
        $address->save();

        return redirect()->route('user.address')->with('status','Address details updated successfully!');
    }
}
