@extends('layouts.primary')

@section('title','All Categories')

@section('bread_list')
<ul class="bread-list">
    <li><a href={{ route('eshop.home') }}>Home<i class="ti-arrow-right"></i></a></li>
    <li class="active"><a href={{ route('category.index') }}> All Categories</a></li>    
</ul>
@endsection

@section('content')
    @include('partials._breadcumb')
    <!-- Start Shop Blog  -->
	<section class="shop-blog section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-title">
						<h2>All Categories</h2>
					</div>
				</div>
			</div>
			<div class="row">
                @foreach ($categories as $category)
                    <div class="col-lg-4 col-md-6 col-12">
					<!-- Start Single Category -->
					<div class="shop-single-blog">
						<img class="default-img" src="{{ $category->image == ''?"https://via.placeholder.com/300x300":image_crop($category->image,300,300) }}" alt="#">
						<div class="content">
							<a href={{ route('category.single',$category->id) }} class="title">{{ $category->name }}</a>
							<a href={{ route('category.single',$category->id) }} class="more-btn">View Category</a>
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
@stop
