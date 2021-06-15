<div class="container-fluid px-1 py-5 mx-auto">
    <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-8 col-md-10 col-12 text-center mb-5">
            <h2 class="text-secondary">All Reviews For {{$product->name}} ({{$reviews->count()}})</h2>
            @if ($reviews->count() > 0)
            <div class="card">
                <div class="row justify-content-left d-flex">
                    <div class="col-md-4 d-flex flex-column">
                        <div class="rating-box">
                            <h1 class="pt-4">{{$product->average_rating}}</h1>
                            <p class="">out of 5</p>
                        </div>
                        <div> 
                        @for ($i=1;$i<=5;$i++)
                            @if ($i <= $product->average_rating)
                            <span class="fa fa-star star-active mx-1"></span> 
                            @else 
                            <span
                            class="fa fa-star star-inactive mx-1"></span>
                            @endif
                        @endfor    
                     </div>
                    </div>
                    @php
                        $starCount5 = 0;
                        $starCount4 = 0;
                        $starCount3 = 0;
                        $starCount2 = 0;
                        $starCount1 = 0;
                        foreach($product->reviews as $review){
                            if($review->rating > 4){
                                $starCount5 += 1;
                            }elseif ($review->rating > 3) {
                                $starCount4 += 1;
                            }elseif ($review->rating > 2) {
                                $starCount3 += 1;
                            }elseif($review->rating > 1){
                                $starCount2 += 1;
                            }else{
                                $starCount1 += 1;
                            }
                        }

                    @endphp
                    <div class="col-md-8">
                        <div class="rating-bar0 justify-content-center">
                            <table class="text-left mx-auto">
                                <tr>
                                    <td class="rating-label">Excellent</td>
                                    <td class="rating-bar">
                                        <div class="bar-container">
                                            <div class="bar-5"></div>
                                        </div>
                                    </td>
                                    <td class="text-right">{{$starCount5}}</td>
                                </tr>
                                <tr>
                                    <td class="rating-label">Good</td>
                                    <td class="rating-bar">
                                        <div class="bar-container">
                                            <div class="bar-4"></div>
                                        </div>
                                    </td>
                                    <td class="text-right">{{$starCount4}}</td>
                                </tr>
                                <tr>
                                    <td class="rating-label">Average</td>
                                    <td class="rating-bar">
                                        <div class="bar-container">
                                            <div class="bar-3"></div>
                                        </div>
                                    </td>
                                    <td class="text-right">{{$starCount3}}</td>
                                </tr>
                                <tr>
                                    <td class="rating-label">Poor</td>
                                    <td class="rating-bar">
                                        <div class="bar-container">
                                            <div class="bar-2"></div>
                                        </div>
                                    </td>
                                    <td class="text-right">{{$starCount2}}</td>
                                </tr>
                                <tr>
                                    <td class="rating-label">Terrible</td>
                                    <td class="rating-bar">
                                        <div class="bar-container">
                                            <div class="bar-1"></div>
                                        </div>
                                    </td>
                                    <td class="text-right">{{$starCount1}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <h5 class="text-secondary text-center">This Product Has No Reviews.</h5>    
            @endif
            
            @foreach ($reviews as $review)
            <div class="card">
                <div class="row d-flex">
                    <div class=""> <img class="profile-pic" src="{{$review->user->image == ''?"https://www.gravatar.com/avatar/".Auth::user()->email."?s=80&d=robohash":image_crop($review->user->image,100,100)}}"> </div>
                    <div class="d-flex flex-column">
                        <h3 class="mt-2 mb-0">{{$review->user->name}}</h3>
                        <div>
                            <p class="text-left"><span class="text-muted">{{$review->rating}}</span> 
                            @for ($i=1;$i<=5;$i++)
                                @if($i < $review->rating)
                                <span
                                class="fa fa-star star-active ml-1"></span>
                                @else
                                <span
                                class="fa fa-star star-inactive ml-1"></span>
                                @endif
                            @endfor
                            </p>
                        </div>
                    </div>
                    <div class="ml-auto">
                        <p class="text-muted pt-5 pt-sm-3">{{$review->created_at->diffForHumans()}}</p>
                    </div>
                </div>
                <div class="row text-left">
                    {{-- <h4 class="blue-text mt-3">"An awesome activity to experience"</h4> --}}
                    <p class="content mt-4">"{{$review->review}}"</p>
                </div>
            </div>
            @endforeach
            @auth
            @can('review-product',$product)
            {{-- Reviews and rating form --}}
            <form class="form" action="{{route('admin.reviews.store')}}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <input type="hidden" name="user_id" value="{{Auth::id()}}">
                <div class="card">
                    <div class="reply-head">
                        <div class="card-body text-center"> <span class="myratings"></span>
                            <h4 class="my-2">Rate {{$product->name}}</h4>
                            <fieldset class="rating col-8 offset-auto" required>
                                <input type="radio" id="star5" name="rating" value="5" />
                                <label class="full" for="star5" title="Awesome - 5 stars"></label>
                                 <input type="radio" id="star4half" name="rating" value="4.5" />
                                <label class="half" for="star4half" title="Pretty good - 4.5 stars"></label> 
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label class="full" for="star4" title="Pretty good - 4 stars"></label>
                                <input type="radio" id="star3half" name="rating" value="3.5" />
                                <label class="half" for="star3half" title="Meh - 3.5 stars"></label> 
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label class="full" for="star3" title="Meh - 3 stars"></label>
                                <input type="radio" id="star2half" name="rating" value="2.5" />
                                <label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label> 
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label class="full" for="star2" title="Kinda bad - 2 stars"></label> 
                                <input type="radio" id="star1half" name="rating" value="1.5" />
                                <label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label class="full" for="star1" title="Sucks big time - 1 star"></label> 
                                <input type="radio" id="starhalf" name="rating" value="0.5" />
                                <label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                {{-- <input type="radio" class="reset-option reset-button" name="rating" value="0" checked/> --}}
                            </fieldset>
                        </div>
                        <h2 class="reply-title">Write Your Review</h2>
                        <!-- Comment Form -->

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Review<span>*</span></label>
                                    <textarea name="review" placeholder="" required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group button">
                                    <button type="submit" class="btn" id="reviewSubmitBtn">Submit Review</button>
                                </div>
                            </div>
                        </div>
            </form>
            @else
            {{-- {{dd(App\Models\ReviewAndRating::where('user_id',Auth::id())->where('product_id',$product->id)->get()) }} --}}
            {{-- {{dd(Auth::user()->review)}} --}}
            @if(App\Models\ReviewAndRating::where('user_id',Auth::id())->where('product_id',$product->id)->get()->count() > 0)
            <div class="card">
                <h5 class="text-info m-3">You Have Already Reviewed This Product <br> This is Your Review</h5>
                <hr>
                <div class="row d-flex">
                    <div class=""> <img class="profile-pic" src="{{Auth::user()->image==''?"https://www.gravatar.com/avatar/".Auth::user()->email."?s=80&d=robohash":image_crop(Auth::user()->image,100,100)}}"> </div>
                    <div class="d-flex flex-column">
                        <h3 class="mt-2 mb-0">{{Auth::user()->name}}</h3>
                        <div>
                            <p class="text-left"><span class="text-muted">{{App\Models\ReviewAndRating::where('user_id',Auth::id())->where('product_id',$product->id)->first()->rating}}</span> 
                                @for ($i=1;$i<=5;$i++)
                                @if($i <= App\Models\ReviewAndRating::where('user_id',Auth::id())->where('product_id',$product->id)->first()->rating)
                                <span
                                    class="fa fa-star star-active ml-1">
                                </span>
                                @else
                                <span
                                class="fa fa-star star-inactive"></span>
                                @endif
                                @endfor
                                </p>
                        </div>
                    </div>
                    <div class="ml-auto">
                        <p class="text-muted pt-5 pt-sm-3">{{App\Models\ReviewAndRating::where('user_id',Auth::id())->where('product_id',$product->id)->first()->created_at->diffForHumans()}}</p>
                    </div>
                </div>
                <div class="row text-left">
                    {{-- <h4 class="blue-text mt-3">"{{Auth::user()->review->review}}"</h4> --}}
                    <p class="content mt-3 text-center">"{{App\Models\ReviewAndRating::where('user_id',Auth::id())->where('product_id',$product->id)->first()->review}}"</p>
                </div>
            </div>
            @endif
            @endcan
            @endauth
            <!-- End Comment Form -->
        </div>
    </div>
</div>
</div>
</div>
