<?php

namespace App\Http\Controllers;

use PDF;
use Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MyFirstNotification;

class AdminCantroller extends Controller
{
    public function view_category()
    {
        if(Auth::id())
        {
            $data = Category::all();
            return view('admin.category',compact('data'));
        }
        else{
            return redirect('login');
        }

    }

  

    public function add_category(Request $request)
    {
        $data = new Category;
        $data->category_name = $request->category;
        $data->save();
        return redirect()->back()->with('message','Category Added Successfully');
    }

    public function delete_category($id)
    {
       if(Auth::id())
       {
        $data = Category::find($id);
        $data->delete();
        return redirect()->back()->with('message','Categoriy Deleted Successfully');
        
       }
       else{
        return redirect('login');
       }
    }


    public function view_product()
    {
   if(Auth::id())
   {
    $category = Category::all();

    return view('admin.product',compact('category'));
   }
   else{
    return redirect('login');
   }
    }

    public function add_product(Request $request)
    {
        $product = new Product;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->discount_price = $request->dis_price;
        $product->category = $request->category;

        $image = $request->image;
        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $request->image->move('product', $imagename);
        $product->image = $imagename;

        $product->save();

        return redirect()->back()->with('message','Product Added Successfully');
    }

    public function show_product()
    {
        $product = Product::all();
        return view('admin.show_product',compact('product'));
    }

    public function delete_product($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->back()->with('message', 'Product Deleted Successfully');
    }

    public function update_product($id)
    {
        $product = Product::find($id);
        $category = Category::all();
        return view('admin.update_product',compact('product','category'));
    }

    public function update_product_confirm(Request $request,$id)
    {
        if(Auth::id())
        {
            $product = Product::find($id);

            $product->title = $request->title;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->discount_price = $request->dis_price;
            $product->category = $request->category;
            $product->quantity = $request->quantity;
    
            $image = $request->image;
            if ($image) {
    
    
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $request->image->move('product', $imagename);
                $product->image = $imagename;
            }
            $product->save();
            return redirect()->back()->with('message', 'Product Added Seccessfully');
    
        }
        else{
            return redirect('login');
        }
        
    }

    public function order()
    {
        $order=Order::all();
        return view('admin.order', compact('order'));
    }


    public function  delivered($id)
    {
      if(Auth::id())
      {
        $order=Order::find($id);
        $order->delivery_status='Delivered';
        $order->payment_status='Paid';
        $order->save();
        return redirect()->back();
      }
      else{
        return redirect('login');
      }

    }


    public function print_pdf($id)
    {
      if(Auth::id())
      {
        $order=Order::find($id);
        $order->delivery_status='Delivered';
        $order->payment_status='Paid';
        $order->save();
        return redirect()->back();
      }
      else{
        return redirect('login');
      }
    }


    public function send_email($id)
    {
        $order=Order::find($id);

        return view('admin.email_info',compact('order'));
    }

    public function send_user_email(Request $request,$id)
    {
      if(Auth::id())
      {
        $order=Order::find($id);
        $details=[
             'greeting'=>$request->greeting,
             'firstline'=>$request->firstline,
             'body'=>$request->body,
             'button'=>$request->button,
             'url'=>$request->url,
             'lastline'=>$request->lastline,
        ];

        Notification::send($order,new MyFirstNotification($details));
        return redirect()->back();
      }
      else{
        return redirect('login');
      }
    }

    public function searchdata(Request $request)
    {
        $searchText=$request->search;
        

        $order = Order::where('name','LIKE',"%$searchText%")->orWhere('phone','LIKE',"%$searchText%")->orWhere('product_title','LIKE',"%$searchText%")->get();
        return view('admin.order',compact('order'));

    }

}
