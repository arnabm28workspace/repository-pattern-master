@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
	<div class="fixed-row">
		<div class="app-title">
			<div class="active-wrap">
				<h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
				<div class="form-group">
		   <button class="btn btn-primary" type="button" id="btnSave"><i class="fa fa-check-circle"></i>Save Page</button>
			<a class="btn btn-secondary" href="{{ route('admin.pages.index') }}"><i style="vertical-align: baseline;" class="fa fa-chevron-left"></i>Back</a>
		</div>
			</div>
		</div>
	</div>
	@include('admin.partials.flash')
	<div class="row section-mg row-md-body no-nav">
		<div class="col-md-12 mx-auto">
				<?php 
				  if(empty($pagetypes[0]->name))
				  { ?>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button class="close" type="button" data-dismiss="alert">×</button>
						<strong>Error!</strong> Please add the Page Types-
						<ol>
						  <li>Top Level</li>
						  <li>Categories</li>
						  <li>Location</li>
						</ol>
					</div>
				 <?php 
				  } else { ?>
					<form action="{{ route('admin.pages.store') }}" method="POST" role="form" enctype="multipart/form-data" id="page_create_form">
						@csrf
						<div class="tile">
							<div class="tile-body form-body">
								<div class="form-group">
									<label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
									<input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}"/>
									@error('name') {{ $message }} @enderror
								</div>
								<div class="form-group">
									<label class="control-label" for="title">Title <span class="m-l-5 text-danger"> *</span></label>
									<input class="form-control @error('name') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
									@error('title') {{ $message }} @enderror
								</div>
								<div class="form-group">
									<label>Page Type<span style="color:red; font-size:55%">★</span></label>
									<select name="page_type" id="page_type" class="form-control" style="width: 100%;">
										@foreach($pagetypes as $pagetype)
										
										<option value="{{ $pagetype->name }}">{{ $pagetype->name }}</option>
										
										@endforeach
									</select>
								</div>
								<?php 
								if($pagetypes[0]->name == 'Location') { ?>
								<div class="page_location">
									<div class="form-group page_country_city">
										<div class="form-check">
											<label class="form-check-label">
												<input type="radio" class="form-check-input location-page" name="optpage" value="country">Page for Country
											</label>
										</div>
										<div class="form-check">
											<label class="form-check-label">
												<input type="radio" class="form-check-input location-page" name="optpage" value="city" checked>Page for State/City
											</label>
										</div>
									</div>
									
									<div class="form-group" id="country">
										<label class="control-label">Country</label>
										<select name="country" id="page_country" class="form-control">
											<!-- <option>Select Country</option>  -->
											@foreach($countries as $key=>$country)
											<option data-cities="{{$country->city_list}}" value="{{$country->slug}}" {{$key == 0 ? 'selected':''}} >{{ $country->name }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group" id="city">
										<label class="control-label">City</label>
										<select name="city" id="page_city" class="form-control">
										</select>
									</div>
									<div class="form-group" id="category_type">
										<label class="control-label">Category</label>
										<select name="category_type" id="page_category" class="form-control">
											@foreach($categorytypes as $categorytype)
											<option value="{{$categorytype->slug}}">{{$categorytype->name}}</option>
											@endforeach
										</select>
									</div>
									<!-- <div class="form-group">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="checkbox" class="form-check-input location-category" name="optcategory" value="category">Show all the ads from the Category
											</label>
										</div>
									</div> -->
									
									<!-- <div class="form-group" id="city">
										<label class="control-label">City</label>
										<select name="city" id="page_city" class="form-control">
										</select>
									</div> -->
									<!-- <div class="form-group" id="category_type">
										<label class="control-label">Category</label>
										<select name="category_type" id="page_category" class="form-control">
											<option disabled selected value>Select Category</option>
											@foreach($categorytypes as $categorytype)
											<option value="{{$categorytype->slug}}">{{$categorytype->name}}</option>
											@endforeach
										</select>
									</div> -->
								</div>
								<?php 
								}
								?>
													
							
							<div class="form-group">
								<label class="control-label" for="description">Content</label>
								<textarea class="form-control" rows="4" name="description" id="description">{{ old('description') }}</textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Page Image</label>
								<div class="form-input-wrapper">
								<input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
								@error('image') {{ $message }} @enderror
								</div>
							</div>
							<div class="form-group toogle-lg">
								<label class="control-label">Status</label>
								<div class="toggle-button-cover">
									<div class="button-cover">
										<div class="button-togglr b2" id="button-11">
											<input id="toggle-block" type="checkbox" name="status" class="checkbox" checked>
											<div class="knobs"><span>Inactive</span></div>
											<div class="layer"></div>
										</div>
									</div>
								</div>
							</div>
							</div>
						</div>
						<div class="tile">
							<legend>Meta Section</legend>
							<div class="form-group">
								<label class="control-label" for="meta_title">Meta Title</label>
								<input type="text" value="" name="meta_title" id="meta_title" class="form-control">
							</div>
							<div class="form-group">
								<label class="control-label" for="meta_description">Meta Description</label>
								<textarea class="form-control" rows="4" name="meta_description" id="meta_description">{{ old('meta_description') }}</textarea>
							</div>
							<div class="form-group">
								<label class="control-label" for="meta_keyword">Meta Keywords</label>
								<div>
								<input type="text" value="" data-role="tagsinput" name="meta_keyword" id="tags" class="form-control" placeholder="Add Keyword">
								</div>
							</div>
						</div>
					</form>
				 <?php 
				  }
				?>
		</div>
	</div>
	
@endsection
@push('styles')
<link rel="stylesheet" type="text/css" href="{{asset('backend/css/bootstrap-tagsinput.css')}}">
<style type="text/css">
  .bootstrap-tagsinput .tag {
	margin-right: 2px;
	padding: 2px 7px;
	background: #d8d8d8;
	color: black;
	display: inline-block;
  }
</style>
@endpush
@push('scripts')
<script type="text/javascript" src="{{asset('backend/js/plugins/bootstrap-tagsinput.js')}}"></script>
<script type="text/javascript">
  
	$('#tags').tagsinput({
		confirmKeys: [13, 32, 44]
	});
	$('#page_create_form').on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) { 
		e.preventDefault();
		return false;
		}
	});

	$("#btnSave").on("click",function(){
		$('#page_create_form').submit();
	});

	$(document).on("change", "#page_type", function(){
		if($(this).val() == "Location"){
			$(".page_location").css("display", "block");
			$(".page_country_city").css("display", "block");
			//$(".page_category").css("display", "none");
			$("#category_type").css("display", "none");

			if($(".location-page:checked").val() == "city"){
				$("#city").css("display", "block");
				var optHtml = populateCity($("#page_country"));
				$('#page_city').html(optHtml);
			} else{
				$("#city").css("display", "none");
				var optHtml = '<option disabled selected value>Select City</option>'
				$('#page_city').html(optHtml);
			}

		} else if($(this).val() == "Categories"){
			//$(".page_category").css("display", "block");
			$(".page_location").css("display", "block");
			$("#category_type").css("display", "block");
			$("#city").css("display", "block");
			$(".page_country_city").css("display", "none");
			var optHtml = populateCity($("#page_country"));
			$('#page_city').html(optHtml);
		}
		else{
			$(".page_location").css('display', "none");
			$(".page_country_city").css("display", "none");
			//$(".page_category").css("display", "none");
			$("#category_type").css("display", "none");
		}
	});

	$(document).ready(function(){
		if($(".location-page:checked").val() == "city"){
			$("#city").css("display", "block");
			var optHtml = populateCity($("#page_country"));
			$('#page_city').html(optHtml);
		} else{
			$("#city").css("display", "none");
			var optHtml = '<option disabled selected value>Select City</option>'
			$('#page_city').html(optHtml);
		}
		$("#category_type").css("display", "none");
		//if($(".location-type:checked").val() == "country"){
			//$("#city").css("display", "none");
			//$("#category_type").css("display", "none");
		//}
	});

	$(document).on("change", ".location-page", function(){
		if (this.checked){
			if($(this).val() == 'country'){
				$("#city").css("display", "none");
				var optHtml = '<option disabled selected value>Select City</option>'
				$('#page_city').html(optHtml);
			}else{
				$("#city").css("display", "block");
				var optHtml = populateCity($("#page_country"));
				$('#page_city').html(optHtml);
			}
		}
	});

	$(document).on("change", ".location-city", function(){

		if (this.checked){
			$("#city").css("display", "block");
			var optHtml = populateCity($("#page_country"));
			$('#page_city').html(optHtml);
		} else{
			$("#city").css("display", "none");
			var optHtml = '<option disabled selected value>Select City</option>'
			$('#page_city').html(optHtml);
		}
	});

	/* $(document).on("change", ".location-category", function(){

		this.checked ? $("#category_type").css("display", "block"):$("#category_type").css("display", "none");
	}); */

	$(document).on("change", "#page_country", function(){
		var optHtml = populateCity($(this));
        $('#page_city').html(optHtml);
	});

	function populateCity(selector){
		var citiesArr = [];
        var citiesStr = selector.find('option:selected').data("cities");
        
        citiesArr = (citiesStr != "" ? citiesStr.split(",") : '');
        //var optHtml = '<option value="">Select City</option>';
		var optHtml = '';
		for(var i=0; i<citiesArr.length; i++){
            optHtml += '<option value="'+citiesArr[i].toLowerCase()+'">'+citiesArr[i]+'</option>';
		}
		
		return optHtml;
	}
</script>
@endpush