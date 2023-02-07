<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')
    <style>
        .center
        {
            margin: auto;
            width: 50%;
            border: 2px solid white;
            text-align: center;
            margin-top: 40px;

        }
        .font_size
        {
            text-align: center;
            font-size: 40px;
            padding-top: 20px;

        }
        .tr_border
        {
            border: 2px solid white;
            font-size: 20px;
            color: skyblue;
            padding: 10px;
        }
        .image
        {
            width: 80px;
        }
        td
        {
            padding: 10px;
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
      
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
        <!-- partial -->
      @include('admin.header')
        <!-- partial -->

        
        <div class="main-panel">
            <div class="content-wrapper">

                @if (session()->has('message'))
                <div class="alert alert-success">
                    <button type="button" class="btn-close" data-dismiss="alert" >X</button>
                    {{ session()->get('message') }}
                </div>
                    
                @endif

                <h2 class="font_size">All Products</h2>

                <table class="center">

                    <tr class="tr_border">
                        <td>Product Title</td>
                        <td>Description</td>
                        <td>Quantity</td>
                        <td>Category</td>
                        <td>Price</td>
                        <td>Discount Price</td>
                        <td>Product Image</td>
                        <td>Delete</td>
                        <td>Edit</td>
                    </tr>

                    @foreach ($product as $product)
                        
                    <tr>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->category }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->discount_price }}</td>
                        <td>
                            <img class="image" src="/product/{{ $product->image }}" alt="">
                        </td>

                        <td>
                            <a onclick="return confirm('Are sure to delete the is product') " class="btn btn-danger" href="{{ url('delete_product',$product->id) }}">Delete</a>
                        </td>
                            
                        <td>
                            <a class="btn btn-success" href="{{ url('update_product',$product->id) }}">Edit</a>
                        </td>
                    </tr>
                    @endforeach

                </table>
            </div>
        </div>
        
        
    <!-- container-scroller -->
    <!-- plugins:js -->
       @include('admin.script')
  </body>
</html>