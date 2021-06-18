@section('title',Auth::user()->name.' - Edit Review For '.$review->product->name)
<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <h2>Edit Review For: {{ $review->product->name }}</h2>
                @php
                    $ratingOptions = [0.5,1,1.5,2,2.5,3,3.5,4,4.5,5];
                @endphp
                <form action={{ route('admin.reviews.update',$review->id) }} method='POST' enctype="multipart/form-data">
                    {{-- here we need to use POST instead of put in html as html forms only support post and get--}}
                    {{-- Then we need to add the put method as hiden field --}}
                    @method('PUT')
                    @csrf
                    <label for="rating" class="mt-4">Edit Rating: </label>
                    <select name="rating" id="rating" class="form-control">
                        @foreach ($ratingOptions as $rating)    
                        <option value="{{$rating}}" {{$rating == $review->rating ? "selected":""}}>{{$rating}}</option>
                        @endforeach
                    </select>
                    @error('rating')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    <label for="review" class="mt-4">Edit Your Review</label>
                    <textarea name="review" id="review" cols="30" rows="10" class="form-control @error('review') is-invalid @enderror" required>{{$review->review}}</textarea>
                    @error('review')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                {{-- for submit btn --}}
                <input type="submit" value="Update Review" name="submit" class="btn btn-primary btn-block mt-4">
                </form>
                <a href={{ route('admin.reviews.show',$review->id) }} class="btn btn-warning btn-block mt-2">Discard Changes</a>
            </div>
        </div>
    </div>

    @section('scripts')
    <script>
        document.getElementById("reviews").classList.add("active");
    </script>
    @stop
    </x-admin.layout>