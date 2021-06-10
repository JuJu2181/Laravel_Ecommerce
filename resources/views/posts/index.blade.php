@extends('layouts.primary')

@section('title','All Blogs')

@section('bread_list')
<ul class="bread-list">
    <li><a href={{ route('eshop.home') }}>Home<i class="ti-arrow-right"></i></a></li>
    <li class="active"><a href={{ route('posts.index') }}>All Blogs</a></li>
</ul>
@endsection

@section('content')
@include('partials._breadcumb')
<!-- only in shop-grid -->

	<!-- Start Shop Blog  -->
	<section class="shop-blog section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-title">
						<h2>All Blogs</h2>
					</div>
				</div>
			</div>
			<div class="row">
                @foreach ($posts as $post)
                    <div class="col-lg-4 col-md-6 col-12">
					<!-- Start Single Blog  -->
					<div class="shop-single-blog">
						<img src="{{$post->image==''?'https://via.placeholder.com/370x300':image_crop($post->image,370,300)}}" alt="#">
						<div class="content">
							<p class="date">{{ $post->created_at->diffForHumans() }}</p>
							<a href={{ route('post.single',$post->slug) }} class="title">{{ $post->title }}</a>
							 <p class="text-info">By {{$post->user->name}}</p>
                            <p class="text-warning">{{$post->category->name}}</p>
                            <p>{{ Str::substr($post->body, 0, 50) }} {{ strlen($post->body) > 50 ? "...": "" }}</p>
							<a href={{ route('post.single',$post->slug) }} class="more-btn">Continue Reading</a>
						</div>
					</div>
					<!-- End Single Blog  -->
				</div>
                @endforeach
				<div class="mx-auto mt-4">
					{{$posts->links()}}
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Blog  -->
@include('partials._newsletter')
@include('partials._modal')
@endsection

@section('scripts')
    <script>
        document.getElementById("blog").classList.add("active");
    </script>
@endsection