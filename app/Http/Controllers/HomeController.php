<?php

namespace App\Http\Controllers;

use Stripe;
use Session;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PharIo\Manifest\Author;

class HomeController extends Controller
{

    public function index()
    {
        $product = Product::paginate(10);
        return view('home.userpage',compact('product'));
    }
    public function redirect()
    {
        $usertype = Auth::user()->usertype;
        if($usertype==1)
        {
            $total_product=Product::all()->count();
            $total_order=Order::all()->count();
            $total_user=User::all()->count();
            $order=Order::all();
            $totla_revenue=0;
            foreach($order as $order)
            {
                $totla_revenue=$totla_revenue + $order->price;
            }

            $total_delivered=Order::where('delivery_status','=','delivered')->get()->count();

            $total_processing=Order::where('delivery_status','=','processing')->get()->count();
            return view('admin.home',compact('total_product','total_order','total_user','totla_revenue','total_delivered','total_processing'));
        }
        else
        {
            $product = Product::paginate(10);
            return view('home.userpage', compact('product'));
        }
    }

   public function product_details($id)
   {
        $product = Product::find($id);
        return view('home.product_details', compact('product'));
   }


   public function add_cart(Request $request ,$id)
   {
    if(Auth::id())
    {

        $user=Auth::user();
        $product=Product::find($id);
        $cart=new Cart;
        $cart->name=$user->name;
        $cart->email=$user->email;
        $cart->phone=$user->phone;
        $cart->address=$user->address;
        $cart->user_id=$user->id;

        $cart->product_title=$product->title;
        if($product->discount_price!= null)
        {
            $cart->price=$product->discount_price*$request->quantity;

        }
        else
        {
            $cart->price=$product->price*$request->quantity;

        }
        $cart->image=$product->image;
        $cart->product_id=$product->id;
        $cart->quantity=$request->quantity;
        $cart->save();
        return redirect()->back();

    }
    else
    {
        return redirect('login');
    }
   }

   public function show_cart()
   {
    if(Auth::id())
    {

    
    $id=Auth::user()->id;
    $cart=Cart::where('user_id','=',$id)->get();

    return view('home.showcart',compact('cart'));
   }
   else
   {
    return redirect('login');
   }
}

public function remove_cart($id)
{
    $cart=Cart::find($id);
    
    $cart->delete();
    
    return redirect()->back()->with('message','Cart Deleted Successfully');
}

public function cash_order()
{
    $user=Auth::user();
    $userid=$user->id;
    $data=Cart::where('user_id','=',$userid)->get();
    foreach($data as $data)
{
    $order=new Order;
    $order->name=$data->name;
    $order->email=$data->email;
    $order->phone=$data->phone;
    $order->address=$data->address;
    $order->user_id=$data->user_id;
    $order->product_title=$data-> product_title;
    $order->price=$data->price;
    $order->quantity=$data->quantity;
    $order->image=$data->image;
    $order->product_id=$data->product_id;

    $order ->payment_status='cash on delivery';
    $order->delivery_status='processing';
    $order->save();
    $cart_id=$data->id;
    $cart=Cart::find($cart_id);
    $cart->delete();
}
return redirect()->back()->with('message','We Have Received Your Order. We Will Connect With You Soon');


}


public function stripe($totalprice)
{
    return view('home.stripe',compact('totalprice'));
}


public function stripePost(Request $request,$totalprice)
    {
        
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => $totalprice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks for payment." 
        ]);

        $user=Auth::user();
    $userid=$user->id;
    $data=Cart::where('user_id','=',$userid)->get();
    foreach($data as $data)
{
    $order=new Order;
    $order->name=$data->name;
    $order->email=$data->email;
    $order->phone=$data->phone;
    $order->address=$data->address;
    $order->user_id=$data->user_id;
    $order->product_title=$data-> product_title;
    $order->price=$data->price;
    $order->quantity=$data->quantity;
    $order->image=$data->image;
    $order->product_id=$data->product_id;

    $order ->payment_status='Paind';
    $order->delivery_status='processing';
    $order->save();
    $cart_id=$data->id;
    $cart=Cart::find($cart_id);
    $cart->delete();
}
      
        Session::flash('success', 'Payment successful!');
              
        return back();
    }

   public function show_order()
   {
    if(Auth::id()){
        $user= Auth::user();
        $userid=$user->id;
        $order=Order::where('user_id','=',$userid)->get();
        return view('home.order',compact('order'));
    }
    else
    {
        return redirect('login');
    }
   } 

   public function cansel_order($id)
   {
    $order=Order::find($id);
    $order->delivery_status='You cannseled the order';
    $order->save();
    return redirect()->back();
   }
}
