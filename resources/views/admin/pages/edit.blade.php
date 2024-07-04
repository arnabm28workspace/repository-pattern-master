@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
	  <div class="fixed-row">
	  <div class="app-title">
		  <div class="active-wrap">
			  <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
			  <div class="form-group">
				<button class="btn btn-primary" type="button" id="btnSave"><i class="fa fa-check-circle"></i>Update Page</button>
				<a class="btn btn-secondary" href="{{ route('admin.pages.index') }}"><i style="vertical-align: baseline;" class="fa fa-chevron-left"></i>Back</a>
			  </div>
		  </div>
	  </div>
	</div>
	@include('admin.partials.flash')
	<div class="row section-mg row-md-body no-nav">
		<div class="col-md-12 mx-auto">
			<form action="{{ route('admin.pages.update') }}" method="POST" role="form" enctype="multipart/form-data" id="page_edit_form">
			@csrf
				<div class="tile">
					<div class="tile-body form-body">
						<div class="form-group">
							<label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
							<input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name', $targetPage->cms_name) }}"/>
							<input type="hidden" name="id" value="{{ $targetPage->id }}">
							@error('name') {{ $message }} @enderror
						</div>
						<div class="form-group">
							<label class="control-label" for="name">Title <span class="m-l-5 text-danger"> *</span></label>
							<input class="form-control @error('name') is-invalid @enderror" type="text" name="title" id="name" value="{{ old('name', $targetPage->cms_title) }}"/>
							<input type="hidden" name="id" value="{{ $targetPage->id }}">
							@error('name') {{ $message }} @enderror
						</div>
						<div class="form-group">
						<label>Page Type<span style="color:red; font-size:55%">★</span></label>
						<select name="page_type" id="page_type" class="form-control" style="width: 100%;">
							@foreach($pagetypes as $pagetype)
								
								<?php 
								if(strcmp($targetPage->page_type, $pagetype->name)==0)
								{ ?>
								<option value="{{$pagetype->name}}" selected>{{$pagetype->name}}</option>
								<?php 
								}else{
								?>
								<option value="{{$pagetype->name}}">{{$pagetype->name}}</option>
								<?php 
								}
								?>
								
							@endforeach
						</select>
						</div>
						<?php 
						//if(!empty($targetPage->country))
						//{
						?>
							<div class="page_location">
								<div class="form-group page_country_city">
									<div class="form-check">
										<label class="form-check-label">
											<input type="radio" class="form-check-input location-page" name="optpage" value="country" {{ (!empty($targetPage->country) && empty($targetPage->city))?'checked':'' }}>Page for Country
										</label>
									</div>
									<div class="form-check">
										<label class="form-check-label">
											<input type="radio" class="form-check-input location-page" name="optpage" value="city" {{ !empty($targetPage->city)?'checked':'' }}>Page for State/City
										</label>
									</div>
								</div>
								<div class="form-group" id="country">
									<label class="control-label">Country</label>
									<select name="country" id="page_country" class="form-control">
										@foreach($countries as $key=>$country)
										<option data-cities="{{$country->city_list}}" value="{{$country->slug}}" {{ ($targetPage->country == $country->slug)?'selected':'' }}>{{ $country->name }}</option>
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
									<option disabled selected value>Select Category</option>
										@foreach($categorytypes as $categorytype)
										<option value="{{$categorytype->slug}}" {{ ($targetPage->category == $categorytype->slug)?'selected':'' }}>{{$categorytype->name}}</option>
										@endforeach
									</select>
								</div>
								
								<!-- <div class="form-group" id="category_type">
									<label class="control-label">Category</label>
									<select name="category_type" id="page_category" class="form-control">
										@foreach($categorytypes as $categorytype)
										<option value="{{$categorytype->slug}}" {{ ($targetPage->category == $categorytype->slug)?'selected':'' }}>{{$categorytype->name}}</option>
										@endforeach
									</select>
								</div> -->
							</div>
						<?php 
						//}
						?>
						
						<div class="form-group">
							<label class="control-label" for="description">Content</label>
							<textarea class="form-control" rows="4" name="description" id="description">{{ old('description', $targetPage->cms_description) }}</textarea>
						</div>
						
						<div class="form-group">
							<div class="row">
								@if ($targetPage->image != null)
								<div class="col-md-2">
									<figure class="form-image-container">
										<img src="{{ asset('storage/'.$targetPage->image) }}" id="categoryImage" class="img-fluid" alt="img">
									</figure>
								</div>
								@else
								<div class="col-md-2">
									<figure class="form-image-container">
										<img src="{{ asset('frontend/images/no-image-available.png') }}" id="categoryImage" class="img-fluid" alt="img">
									</figure>
								</div>
								@endif
								<div class="col-md-10">
									<label class="control-label">Page Image</label>
									<div class="form-input-wrapper">
										<input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
										@error('image') {{ $message }} @enderror
										<p><small>Choose new image to replace old image</small></p>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group toogle-lg">
							<label class="control-label">Status</label>
							<div class="toggle-button-cover">
								<div class="button-cover">
									<div class="button-togglr b2" id="button-11">
										<input id="toggle-block" type="checkbox" name="status" data-page_id="{{$targetPage->id}}" class="checkbox" {{ $targetPage->status == 1 ? 'checked' : '' }}>
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
						<input type="text" value="{{$targetPage->meta_title}}" name="meta_title" id="meta_title" class="form-control">
					</div>
					<div class="form-group">
						<label class="control-label" for="meta_description">Meta Description</label>
						<textarea class="form-control" rows="4" name="meta_description" id="meta_description">{{ old('meta_description',$targetPage->meta_description) }}</textarea>
					</div>
					<div class="form-group">
						<label class="control-label" for="meta_keyword">Meta Keywords</label>
						<div>
							<input type="text" data-role="tagsinput" name="meta_keyword" id="tags" class="form-control" placeholder="Add Keyword"> 
						</div>
					</div>
				</div>
			</form>
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

	var meta_keyword_values = "<?php echo $targetPage->meta_keyword; ?>";

	$('#tags').tagsinput({
				confirmKeys: [13, 32, 44]
		});
	$('#tags').tagsinput('add',meta_keyword_values);

	$('#page_edit_form').on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) {
			e.preventDefault();
			return false;
		}
	});

	$("#btnSave").on("click",function(){
		$('#page_edit_form').submit();
	});

	/* $(document).on("change", "#page_type", function(){
		if($(this).val() == "Location"){
			$(".page_location").css("display", "block");
		} else{
			$(".page_location").css('display', "none");
		}
	}); */
	$(document).on("change", "#page_type", function(){
		if($(this).val() == "Location"){
			$(".page_location").css("display", "block");
			$(".page_country_city").css("display", "block");
			$("#category_type").css("display", "none");
			$("#page_category > option:selected").prop('selected', false);
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
			$("#category_type").css("display", "none");
			$("#page_category > option:selected").prop('selected', false);
		}
	});

	$(document).ready(function(){
		var selected_pagetype = "<?php echo $targetPage->page_type;?>";
		if (selected_pagetype == "Location"){
			$(".page_location").css("display", "block");
			$(".page_country_city").css("display", "block");
			$("#category_type").css("display", "none");
			$("#page_category > option:selected").prop('selected', false);
		}else if (selected_pagetype == "Categories"){
			$(".page_location").css("display", "block");
			$(".page_country_city").css("display", "none");
			var category = "<?php echo $targetPage->category;?>";
			if(category.length > 0) {
				$("#category_type").css("display", "block");
			}
		}
		else{
			$(".page_location").css('display', "none");
			$(".page_country_city").css("display", "none");
			$("input:radio[name=optpage]:first").attr('checked', true);
		}
		$("#city").css("display", "none");
		//$("#category_type").css("display", "none");

		var city = "<?php echo $targetPage->city;?>";
		if(city.length > 0) {
			$("#city").css("display", "block");
		}

		var optHtml = populateCity($("#page_country"), city);
		$('#page_city').html(optHtml);
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

	$(document).on("change", ".location-category", function(){

		if (this.checked){
			$("#category_type").css("display", "block");
		} else{
			$("#page_category > option:selected").prop('selected', false);
			$("#category_type").css("display", "none");
		}
	});

	$(document).on("change", "#page_country", function(){
		var optHtml = populateCity($(this));
        $('#page_city').html(optHtml);
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

	function populateCity(selector, selected=''){
		var citiesArr = [];
        var citiesStr = selector.find('option:selected').data("cities");
        
        citiesArr = (citiesStr != "" ? citiesStr.split(",") : '');
        //var optHtml = '<option value="">Select City</option>';
		var optHtml = '';
		for(var i=0; i<citiesArr.length; i++){
            optHtml += '<option value="'+citiesArr[i].toLowerCase()+'" '+(citiesArr[i].toLowerCase()==selected?"selected":"")+'>'+citiesArr[i]+'</option>';
		}
		
		return optHtml;
	}
</script>
@endpush