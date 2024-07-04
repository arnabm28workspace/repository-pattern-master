<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>@yield('title') - {{ $site_name }}</title>
	
	<meta name="description" content="{{ !empty($page->meta_description)?strip_tags($page->meta_description):'' }}">
  	<meta name="keywords" content="{{ !empty($page->meta_keyword)?$page->meta_keyword:'' }}">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/9f69eaf4a1.js" crossorigin="anonymous"></script>
    <!-- Google Fonts -->
  	<link href="https://fonts.googleapis.com/css?family=Righteous&display=swap" rel="stylesheet">
   	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap" rel="stylesheet">
   	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
    <!-- Google Fonts End -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/basic.css" rel="stylesheet" type="text/css" /> -->
    <link rel='stylesheet' href="{{ asset('frontend/css/main.css')}}"/>
    <style type="text/css">
		.dropzone {
			border:2px dashed #999999;
			border-radius: 10px;
		}
		.dropzone .dz-default.dz-message {
			height: 0;
			padding-top: 200px;
		}
		.dropzone .dz-default.dz-message span {
			display: block;
			text-align: center;
			line-height: 170px;
			font-size: 18px;
			font-weight: normal;
			font-family: Montserrat;
		} 
		.dz-preview .dz-image img{
			width: 100% !important;
			height: 100% !important;
			object-fit: cover;
		}
		.error-cls{
			color: #ff0000;
			font-size: 12px;
			font-weight: 400;
			display: none;
		}
	</style>
    @stack('styles')
</head>
<body>
    @include('site.partials.header')
    @yield('content')
    <section class="container-fluid footer_add-post py-5 mt-4 text-center">
        <div class="row">
            <div class="col-12">
                <h4 class="text-white mb-4 mb-lg-0 align-middle d-inline-block">POST YOUR ADVERT TODAY</h4> 
                <a href="javascript:void(0);" class="btn btn--md d-inline-block ml-3 text-capitalize post-ad-button">Post your ad</a>
            </div>
        </div>
    </section>
    @include('site.partials.footer')
<div class="footer_credit text-center py-5 border-top">© <?php echo date("Y");?> {{ config('app.name') }}. Design and development by <a href="https://www.adultcreative.co.uk/">Adult Creative</a><a class="mx-4" href="{{ route('report-bug') }}">Report a bug</a></div>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
<script type="text/javascript">
$(document).on('click','.post-ad-button', function(){
    var loggedIn = {{ auth()->check() ? 'true' : 'false' }};
    if (!loggedIn)
    {
    	swal({
			title: "",
			text: "You are not authorized to post ad. Only registered user can post a new ad. Please register.",
			showCancelButton: true,
			cancelButtonClass: "btn-danger",
			confirmButtonText: "Interested",
			closeOnConfirm: false
		},
		function(isConfirm){
			if (isConfirm) {
			window.location.href = "login";
			}
		}); 
    }else{
    	window.location.href = "{{route('user.post.ad')}}";
    }
});

$(document).on('ready', function() {
	$('.home-slider').slick({
		autoplay:true,
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 4,
		adaptiveHeight: true,
		slidesToScroll: 1,
		responsive: [
		{
			breakpoint: 1024,
			settings: {
			slidesToShow: 3,
			slidesToScroll: 3,
			infinite: true,
			dots: true
			}
		},
		{
			breakpoint: 600,
			settings: {
			slidesToShow: 2,
			slidesToScroll: 2
			}
		},
		{
			breakpoint: 480,
			settings: {
			dots: true,
			slidesToShow: 1,
			slidesToScroll: 1
			}
		}
		]
	});
	$('.feature-slider').slick({
		autoplay:true,
		dots: false,
		infinite: true,
		centerMode: false,
		speed: 300,
		slidesToShow: 4,
		adaptiveHeight: true,
		slidesToScroll: 1,
		responsive: [
		{
			breakpoint: 1024,
			settings: {
			slidesToShow: 3,
			slidesToScroll: 3,
			infinite: true,
			dots: true
			}
		},
		{
			breakpoint: 600,
			settings: {
			slidesToShow: 2,
			slidesToScroll: 2
			}
		},
		{
			breakpoint: 480,
			settings: {
			dots: true,
			slidesToShow: 1,
			slidesToScroll: 1
			}
		}
		]
	});
	
	$('.vertical-center-4').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		asNavFor: '.slider-nav',
		lazyLoad: 'ondemand',
		adaptiveHeight: true
	});

	$('.slider-nav').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		asNavFor: '.vertical-center-4',
		lazyLoad: 'ondemand',
		dots: true,
		centerMode: false,
		focusOnSelect: true
	});   
});
</script>
<script src="{{ asset('frontend/js/main.js')}}"></script>
@stack('scripts')
</body>
</html> 
