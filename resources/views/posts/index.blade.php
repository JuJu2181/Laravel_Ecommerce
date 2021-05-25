@extends('layouts.primary')

@section('title','All Blogs')

@section('bread_list')
<ul class="bread-list">
    <li><a href={{ route('eshop.home') }}>Home<i class="ti-arrow-right"></i></a></li>
    <li class="active"><a href={{ route('post.index') }}>All Blogs</a></li>
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
						<img src="https://via.placeholder.com/370x300" alt="#">
						<div class="content">
							<p class="date">{{ date('F j, Y',strtotime($post->created_at)) }}</p>
							<a href={{ route('post.single',$post->id) }} class="title">{{ $post->title }}</a>
                            <p>{{ substr($post->body, 0, 50) }}...</p>
							<a href={{ route('post.single',$post->id) }} class="more-btn">Continue Reading</a>
						</div>
					</div>
					<!-- End Single Blog  -->
				</div>
                @endforeach
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