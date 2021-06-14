<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\ReviewAndRating;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ReviewAndRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::find($request->product_id);
        $orderItems = OrderItem::where('product_id',$request->product_id)->get();
        // return $orderItems;
        $orderItemsForUser = [];
        foreach($orderItems as $orderItem){
            if($orderItem->order->user_id == Auth::id()){
                array_push($orderItemsForUser,$orderItem);
            }
        }
        // return $orderItemsForUser;
        // return $request;
        if(empty($request->rating)){
            $rating = 0;
        }else{
            $rating = $request->rating;
        }
        // return $rating;
        $request->validate(
            [
                'review' => 'required|min:10'
            ],
            // customizing error messages
            [
                'review.required'=>'Please Write Some Review For The Product'
            ]
        );

        $review = new ReviewAndRating;
        $review->product_id = $request->product_id;
        $review->user_id = $request->user_id;
        $review->rating = $rating;
        $review->review = $request->review;
        if($review->save()){
            foreach($orderItemsForUser as $orderItem){
                $orderItem->review_status = "reviewed";
                $orderItem->save();
            }
            $average_rating = 0;
            foreach($product->reviews as $review){
                $average_rating += $review->rating;
            }
            $average_rating = $average_rating/$product->reviews->count();
            $product->average_rating = $average_rating;
            $product->save();
            return redirect()->route('product.single',$review->product_id);
        }else{
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
