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
            $reviews = ReviewAndRating::where('user_id',Auth::id())->paginate(6);
            return view('admin.reviews.index',compact('reviews'));
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
        // return $request;
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
                'review' => 'required'
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
    public function show(ReviewAndRating  $review)
    {
        // return $review;
        return view('admin.reviews.single',compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ReviewAndRating $review)
    {
        if($review->user_id != Auth::id()){
            abort(403);
        }
        return view('admin.reviews.edit',compact('review'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,ReviewAndRating $review)
    {
        // return $request;
        $product = Product::find($review->product_id);
        // return $product;
        if(empty($request->rating)){
            $rating = 0;
        }else{
            $rating = $request->rating;
        }
        // return $rating;
        $request->validate(
            [
                'review' => 'required'
            ],
            // customizing error messages
            [
                'review.required'=>'Please Write Some Review For The Product'
            ]
        );

        $review->rating = $request->rating;
        $review->review = $request->review;
        if($review->save()){
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){

    }



    public function deleteReview($id,$currentPage)
    {
        // return $currentPage;
        $review = ReviewAndRating::find($id);
        $product = Product::find($review->product_id);
        if($review->user_id != Auth::id()){
            abort(403);
        }
        $orderItems = OrderItem::where('product_id',$review->product_id)->get();
        $orderItemsForUser = [];
        foreach($orderItems as $orderItem){
            if($orderItem->order->user_id == Auth::id()){
                array_push($orderItemsForUser,$orderItem);
            }
        }
        foreach($orderItemsForUser as $orderItem){
            $orderItem->review_status = "not_reviewed";
            $orderItem->save();
        }
        $review->delete();
        $average_rating = 0;
            foreach($product->reviews as $review){
                $average_rating += $review->rating;
            }
        $average_rating = $average_rating/$product->reviews->count();
        $product->average_rating = $average_rating;
        $product->save();
        if($currentPage == 'product_detail'){
            return redirect()->route('product.single',$review->product_id);
        }else{
            return redirect()->route('admin.reviews.index');
        }
    }

    public function getProductReviews(){
        if(Auth::user()->role == 'user'){
            abort(403);
        }elseif(Auth::user()->role == 'vendor'){
        if(Auth::user()->vendor_status != 'verified'){
                abort(403);
        }
        $products = Product::where('user_id',Auth::id())->get();
        $productsWithReviews = [];
        foreach($products as $product){
            if($product->reviews->count() > 0){
                array_push($productsWithReviews,$product);
            }
        }
        }else{
            $products = Product::all();
            $productsWithReviews = [];
            foreach($products as $product){
                if($product->reviews->count() > 0){
                    array_push($productsWithReviews,$product);
                }
            }
        }
        // return $productsWithReviews;
        return view('admin.reviews.product_review',compact('productsWithReviews'));
    }

    public function getProductReviewDetail($id){
        $product = Product::find($id);
        return view('admin.reviews.product_review_detail',compact('product'));
    }
}
