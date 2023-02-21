<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <base href="/public">

    @include('admin.css')
    <style>

      label{
        display: inline-block;
        width: 160px;
        font-size: 20px;
        font-weight: bold;
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

              <h1 style="text-align: center;font-size:25px;">Send Email to {{$order->email}}</h1>

              <form action="{{url('send_user_email'),$order->id}}" method="POST">
                @csrf
                
                <div style="padding-left:40%;padding-top:30px;">
                  <label>Email Getting: </label>
                  <input type="text" name="greeting">
                </div>

                <div style="padding-left:40%;padding-top:30px;">
                  <label>Email FristLing: </label>
                  <input type="text" name="fristling">
                </div>

                <div style="padding-left:40%;padding-top:30px;">
                  <label>Email Body: </label>
                  <input type="text" name="body">
                </div>

                <div style="padding-left:40%;padding-top:30px;">
                  <label>Booton Name: </label>
                  <input type="text" name="booton">
                </div>

                <div style="padding-left:40%;padding-top:30px;">
                  <label>Email URL: </label>
                  <input type="text" name="url">
                </div>

                <div style="padding-left:40%;padding-top:30px;">
                  <label>Email Last Line: </label>
                  <input type="text" name="lastline">
                </div>

                <div style="padding-left:40%;padding-top:30px;">
                  <input type="submit" value="Send Email" class="btn btn-primary">
                </div>




                
              </form>
            </div>
        </div>
        

    <!-- container-scroller -->
    <!-- plugins:js -->
       @include('admin.script')
  </body>
</html>