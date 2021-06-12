<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmation For Your Purchase</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css' integrity='sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA==' crossorigin='anonymous'/>
</head>
<body>
    <h2 class="text-info ">Hello {{$name}}, this email is sent for your confirmation on purchase of order {{$order->id}}</h2>
    <h4>Please Enter This Security Code To Verify Your Purchase</h4>
    <h5 class="text-danger">Please Note that this code expires after 2 hours</h5>
    <p class="text-md">Security Code: <Span class="text-danger">{{$security_code}}</Span></p>
    <hr>
    <h3 class="text-primary">Shipping Details</h3>
    <div class="jumbotron text-secondary">
        Order Maker: {{ $name }} <br>
        Contact Number: {{$number}} <br>
        Country : {{$country_name}} <br>
        State: {{$state}} <br>
        Post: {{$post}} <br>
        Address 1: {{$address1}} <br>
        Address 2: {{$address2}} <br>
    </div>
    <h5 class="text-danger">If any details are wrong please kindly donot submit the code instead resubmit the checkout form</h5>
    <hr>
    <h3 class="text-primary">Order Details for Order {{$order->id}}</h3>
    <div class="jumbotron">
        <p>Sub Total: {{$order->sub_total}}</p> 
        <p>Discount: {{$order->discount}}</p> 
        <p>Shipping Price: {{$order->shipping_price}}</p> 
        <p>Total Price: {{$order->total_price}}</p>
    </div>
    <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">S.N</th>
            <th scope="col">Product Name</th>
            <th scope="col">Product Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total Price</th>
            <th scope="col">Date</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $order_item)
            <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{$order_item->product->name}}</td>
            <td>{{$order_item->product_price}}</td>
            <td>{{$order_item->quantity}}</td>
            <td>{{$order_item->total}}</td>
            <td>{{date('M j, Y, g:i a',strtotime($order_item->created_at))}}</td>
            </tr>
        @endforeach
        </tbody>
      </table>
</body>
</html>