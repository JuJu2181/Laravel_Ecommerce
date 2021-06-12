{{-- Creating layout using partials--}}
<!DOCTYPE html>
<html lang="zxx">
<head>
	{{-- using partials--}}
    @include('partials._head')

</head>

<body class="js">
	
	<!-- Preloader -->
    @include('partials._preloader')
	<!-- End Preloader -->
	
	
	<!-- Header -->
    @include('partials._header')
	<!--/ End Header -->
	@include('partials._flash_messages')
    @yield('content')


	<!-- Start Footer Area -->
    @include('partials._footer')
	<!-- /End Footer Area -->
 
	{{-- javascripts --}}
    @include('partials._script')
</body>
</html>