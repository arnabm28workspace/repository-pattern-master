@extends('admin.app')
@push('styles')
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/amsify.suggestags.css') }}"> -->
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/bootstrap-tagsinput.css') }}" />
  <style>
  /*the container must be positioned relative:*/
  	.bootstrap-tagsinput{
		display: block !important;
	}
	.bootstrap-tagsinput .tag {
		margin-right: 2px;
		padding: 2px 7px;
		background: #d8d8d8;
		color: black;
		display: inline-block;
	}
	.is-invalid {
		border-color:#dc3545 !important;
	}
  </style>
@endpush
@section('title') {{ $pageTitle }} @endsection
@section('content')
	<div class="fixed-row">
		<div class="app-title">
			<div class="active-wrap">
				<h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
				<div class="form-group">
		  <button class="btn btn-primary" type="button" id="btnSave"><i class="fa fa-check-circle"></i>Save Country</button>
					<a class="btn btn-secondary" href="{{ route('admin.country.index') }}"><i style="vertical-align: baseline;" class="fa fa-chevron-left"></i>Back</a>
				</div>
			</div>
		</div>
  	</div>
  @include('admin.partials.flash')
  <div class="row section-mg row-md-body no-nav">
	  <div class="col-md-12 mx-auto">
		  <div class="tile">
			  <form action="{{ route('admin.country.store') }}" method="POST" role="form" enctype="multipart/form-data" id="form1">
				  @csrf
				  <div class="tile-body form-body">
					  <!-- <div class="form-group">
						  <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
						  <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}"/>
						  @error('name') {{ $message }} @enderror
					  </div> -->
					  <div class="autocomplete" style="width:400px;">
						  <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
						  <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" placeholder="Country" autocomplete=off>
					  </div>
					  <input  type="hidden" name="code" id="code"/>
					  <input  type="hidden" name="flag" id="flag" value=""/>
					  <div class="form-group">
						  <label class="control-label" for="title">City <span class="m-l-5 text-danger"> *</span></label>
						  <!-- <input class="form-control @error('code') is-invalid @enderror" type="text" name="code" id="code" value="{{ old('code') }}"/> -->
						  <input type="text" value="" data-role="tagsinput" id="tags" class="form-control" name="cities">
						   @error('cities') {{ $message }} @enderror
					  </div>
					  <div class="form-group">
							<label class="control-label" for="order">Order</label>
							<input type="text" id="order" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ old('order') }}">
							@error('order') {{ $message }} @enderror
					  </div>
					  <div class="form-group toogle-lg">
						  <label class="control-label">Status</label>
						  <div class="toggle-button-cover">
							  <div class="button-cover">
								  <div class="button-togglr b2" id="button-11">
									  <input id="toggle-block" type="checkbox" name="status" class="checkbox">
									  <div class="knobs"><span>Inactive</span></div>
									  <div class="layer"></div>
								  </div>
							  </div>
						  </div>
					  </div>
				  </div>
				  <!-- <div class="tile-footer">
					  <button class="btn btn-primary" type="button" id="btnSave"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Country</button>
					  &nbsp;&nbsp;&nbsp;
					  <a class="btn btn-secondary" href="{{ route('admin.country.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
				  </div> -->
			  </form>
		  </div>
	  </div>
  </div>
@endsection
@push('scripts')
  
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('backend/js/plugins/bootstrap-tagsinput.js') }}"></script>
<!-- <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.amsify.suggestags.js') }}"></script> -->
<script type="text/javascript">
	var countries = [];
	var countries_obj = [];
	var all_cities = [];
	var cities = [];

	$(document).ready(function(){
		  // $('#tags').amsifySuggestags({
		  //     suggestions: ['Black', 'White', 'Red', 'Blue', 'Green', 'Orange']
		  // });
		  
		var getCountryUrl = '{{url("admin/country/getcountry")}}';
		$.ajax({
			type:'GET',
			dataType:'JSON',
			url:getCountryUrl,
			data:"",
			success:function(response)
			{
				// console.log("country>>"+JSON.stringify(response));
				countries_obj = response;
				for (var key in countries_obj)
				{
					// var temp_arr = [];
					// temp_arr.push(countries_obj[key])
					countries.push(countries_obj[key])
				}
				// countries = JSON.stringify(countries);
				autocomplete(document.getElementById("name"), countries);
			},
			error: function()
			{
				console.log("error in fetching country list");
			}
		});

		$("#btnSave").on("click",function(){
			if (!$("#tags").val().trim()) {
				$('.bootstrap-tagsinput').addClass('is-invalid');
				$('.bootstrap-tagsinput').next('p').remove();
				$('.bootstrap-tagsinput').after('<p>The cities field is required.</p>');
			} else{
				$('.bootstrap-tagsinput').removeClass('is-invalid');
				$('.bootstrap-tagsinput').next('p').remove();
				$('#form1').submit();
			}
		})
	})
  </script>
  <script>
	  function autocomplete(inp, arr) {
		/*the autocomplete function takes two arguments,
		the text field element and an array of possible autocompleted values:*/
		var currentFocus;
		var cname='';
		console.log(arr)
		/*execute a function when someone writes in the text field:*/
		inp.addEventListener("input", function(e) {
			var a, b, i, val = this.value;
			/*close any already open lists of autocompleted values*/
			closeAllLists();
			if (!val) { return false;}
			currentFocus = -1;
			/*create a DIV element that will contain the items (values):*/
			a = document.createElement("DIV");
			a.setAttribute("id", this.id + "autocomplete-list");
			a.setAttribute("class", "autocomplete-items");
			/*append the DIV element as a child of the autocomplete container:*/
			this.parentNode.appendChild(a);
			/*for each item in the array...*/
			for (i = 0; i < arr.length; i++) {
			  if(arr[i].admin)
			  {
				console.log(arr[i].admin)
				/*check if the item starts with the same letters as the text field value:*/
				if (arr[i].admin.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
				  /*create a DIV element for each matching element:*/
				  b = document.createElement("DIV");
				  /*make the matching letters bold:*/
				  b.innerHTML = "<strong>" + arr[i].admin.substr(0, val.length) + "</strong>";
				  b.innerHTML += arr[i].admin.substr(val.length);
				  /*insert a input field that will hold the current array item's value:*/
				  b.innerHTML += "<input type='hidden' value='" + arr[i].admin + "'>";
				  b.innerHTML += "<input type='hidden' value='" + arr[i].cca2 + "'>";
				  b.innerHTML += "<input type='hidden' value='" + arr[i].flag['flag-icon'] + "'>";

				  /*execute a function when someone clicks on the item value (DIV element):*/
				  b.addEventListener("click", function(e) {
					cities = [];
					var getCityByCountryUrl = '{{url("admin/country/getcitiesbycountry")}}';
					var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
					var country_cca2 = this.getElementsByTagName("input")[1].value;
					/* $.ajax({
					  	type:'POST',
						dataType:'JSON',
						url:getCityByCountryUrl,
						data:{ _token: CSRF_TOKEN, cca2: country_cca2 },
						success:function(response)
						{
							for (var key in response)
							cities.push(response[key].name);
							console.log(response)
							$('#tags').amsifySuggestags({
								type : 'amsify',
								suggestions: cities,
								whiteList: true
							});
						},
						error: function(response)
						{
							console.log(response);
						}
					}); */
					//alert(this.getElementsByTagName("input")[1].value);
					  /*insert the value for the autocomplete text field:*/
					inp.value = this.getElementsByTagName("input")[0].value;
					$('#code').val(this.getElementsByTagName("input")[1].value);
					$('#flag').val(this.getElementsByTagName("input")[2].value);
					  // cname = this.getElementsByTagName("input")[1].value;
					  
					/*close the list of autocompleted values,
					  (or any other open lists of autocompleted values:*/
					  closeAllLists();
				  });
				  a.appendChild(b);
				}
			  }
			  
			}
		});
		/*execute a function presses a key on the keyboard:*/
		inp.addEventListener("keydown", function(e) {
			var x = document.getElementById(this.id + "autocomplete-list");
			if (x) x = x.getElementsByTagName("div");
			if (e.keyCode == 40) {
			  /*If the arrow DOWN key is pressed,
			  increase the currentFocus variable:*/
			  currentFocus++;
			  /*and and make the current item more visible:*/
			  addActive(x);
			} else if (e.keyCode == 38) { //up
			  /*If the arrow UP key is pressed,
			  decrease the currentFocus variable:*/
			  currentFocus--;
			  /*and and make the current item more visible:*/
			  addActive(x);
			} else if (e.keyCode == 13) {
			  /*If the ENTER key is pressed, prevent the form from being submitted,*/
			  e.preventDefault();
			  if (currentFocus > -1) {
				/*and simulate a click on the "active" item:*/
				if (x) x[currentFocus].click();
			  }
			}
		});
		function addActive(x) {
		  /*a function to classify an item as "active":*/
		  if (!x) return false;
		  /*start by removing the "active" class on all items:*/
		  removeActive(x);
		  if (currentFocus >= x.length) currentFocus = 0;
		  if (currentFocus < 0) currentFocus = (x.length - 1);
		  /*add class "autocomplete-active":*/
		  x[currentFocus].classList.add("autocomplete-active");
		}
		function removeActive(x) {
		  /*a function to remove the "active" class from all autocomplete items:*/
		  for (var i = 0; i < x.length; i++) {
			x[i].classList.remove("autocomplete-active");
		  }
		}
		function closeAllLists(elmnt) {
		  /*close all autocomplete lists in the document,
		  except the one passed as an argument:*/
		  var x = document.getElementsByClassName("autocomplete-items");
		  for (var i = 0; i < x.length; i++) {
			if (elmnt != x[i] && elmnt != inp) {
			  x[i].parentNode.removeChild(x[i]);
			}
		  }
		}
		/*execute a function when someone clicks in the document:*/
		document.addEventListener("click", function (e) {
			closeAllLists(e.target);
		});
	  }
</script>
@endpush