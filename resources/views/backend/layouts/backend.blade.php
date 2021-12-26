<!DOCTYPE html>
<html lang="en">

<head>
    @include('backend.includes.backend-head')
</head>

<body class="fix-header card-no-border logo-center">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>

@include('backend.includes.backend-script')

<div id="main-wrapper">	
    @include('backend.includes.top-header')
    @include('backend.includes.navigation')	

	<div class="page-wrapper">		
        @yield('content')
        @include('backend.includes.footer')
	</div>
</div>	 

@yield('scripts')

</body>

</html>
