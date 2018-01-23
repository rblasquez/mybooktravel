<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="author" content="MyBookTravel">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#0ec8db">
	{{--
	<title>{!! Meta::get('title') !!}</title>
	--}}

	<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/icon/apple-icon-57x57.png') }}">
	<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/icon/apple-icon-60x60.png') }}">
	<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/icon/apple-icon-72x72.png') }}">
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/icon/apple-icon-76x76.png') }}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/icon/apple-icon-114x114.png') }}">
	<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/icon/apple-icon-120x120.png') }}">
	<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/icon/apple-icon-144x144.png') }}">
	<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/icon/apple-icon-152x152.png') }}">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/icon/apple-icon-180x180.png') }}">
	<link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('img/icon/android-icon-192x192.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/icon/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/icon/favicon-96x96.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/icon/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('img/icon/manifest.json') }}">
	<meta name="msapplication-TileImage" content="{{ asset('img/icon/ms-icon-144x144.png') }}">


	@stack('head')

	{{--
	{!! Meta::tag('robots') !!}
	{!! Meta::tag('locale', 'es_ES') !!}
	{!! Meta::tag('site_name', 'MyBookTravel') !!}
	{!! Meta::tag('url', Request::url()); !!}

	{!! Meta::tag('title') !!}
	{!! Meta::tag('description') !!}

	{!! Meta::tag('image', asset('img/my_book_travel_logo.svg')) !!}
	--}}


	<title>{{ $meta_og_title }}</title>
	<meta name="description" content="{{ $meta_og_description }}" />


	<meta name="twitter:card" value="summary">


	<meta property="og:title" content="{{ $meta_og_title }}" />
	<meta property="og:type" content="{{ $meta_og_type }}" />
	<meta property="og:url" content="{{ Request::url() }}" />
	<meta property="og:image" content="{{ $meta_og_image }}">
	<meta property="og:description" content="{{ $meta_og_description }}" />


	{{-- CSS --}}
	<style>
		#preloader {
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-color: #fff;
			z-index: 99;
		}

		#status {
			width: 200px;
			height: 200px;
			position: absolute;
			left: 50%;
			top: 50%;
			background-image: url({{ App\Http\Controllers\HelperController::imagenABase64('img/Isotipo_MBT.gif') }});
			background-repeat: no-repeat;
			background-position: center;
			margin: -100px 0 0 -100px;
		}
	</style>

	{!! Html::style("css/esencial.css?$version") !!}
	@if (!Request::is('/'))
		{!! Html::style("css/vendor.css?$version") !!}
		{!! Html::style("css/vendor.print.css?$version", ['media' => 'print']) !!}
	@endif
	{!! Html::style("css/custom.css?$version") !!}

	<style>
		.date-picker-wrapper {
			border: 1px solid #E6E7E8;
			background-color: #fff;
			box-shadow: none;
		}

		.date-picker-wrapper .month-wrapper {
			border: none;
			background-color: #fff;
			box-shadow: none;
		}
		.date-picker-wrapper.no-shortcuts.no-gap.single-month {
			z-index: 10;
		}
	</style>

	@stack('css')

	@if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) || 1==1)
		<script type="text/javascript">
			// Google Tag Manager
			(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-PG3ZNH9');
		// End Google Tag Manager

	</script>
@endif


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body>

	<!-- Google Tag Manager (noscript) -->
	@if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PG3ZNH9" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	@endif
	<!-- End Google Tag Manager (noscript) -->

	{{-- rutas generales precargadas para ser usadas desde js --}}
	<a href="{{ asset('/') }}" class="hide carpetaPublic"></a>
	<a href="{{ asset('/img/marker.png') }}" class="hide marcadorGoogleMap"></a>
	{{-- /rutas generales precargadas para ser usadas desde js --}}

	{{-- Pre-Carga --}}
	<div id="preloader">
		<div id="status">&nbsp;</div>
	</div>
	{{-- /Pre-Carga --}}

	{{-- HEADER --}}
	@include('layouts.partials.header')
	{{-- /HEADER --}}

	{{-- CONTENT --}}
	@yield('content')
	{{-- /CONTENT --}}

	{{-- FOOTER --}}
	@include('layouts.partials.footer')
	{{-- /FOOTER --}}


	{!! Html::script("js/esencial.js?$version") !!}
	@if (Request::is('/'))
		{!! Html::script("js/index.js?$version") !!}
	@else
		{!! Html::script("js/vendor.js?$version") !!}
	@endif
	{{-- Lenguaje de los datepicker --}}
	{{-- {!! Html::script('plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') !!} --}}
	{!! Html::script('https://maps.google.com/maps/api/js?libraries=places&key=AIzaSyBULVo0G2pzkb79frHM3n_YFR-Ao_6CT-8&libraries=places') !!}
	{!! Html::script("js/custom.js?$version") !!}

	@include('sweet::alert')

	@stack('js')

</body>
</html>
