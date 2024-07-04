@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<section class="container page_intro xs-top-spc xs-top-spc-breadcrumbs">
	{{ Breadcrumbs::render('ad-list') }}
</section>
<section class="container admin-panel">
    <div class="admin-panel__bar">
        <h4 class="text-white">Search List</h4>
    </div>
</section>
<section class="container">
    <!-- Search panel -->
    <form action="{{ route('process-search') }}" method="post">
        @csrf
        <input type="hidden" name="search_from" value="search" />
        <div class="c-search-block d-flex justify-content-center mt-3">
            <div class="c-search-block__inner col-lg-12 py-5 px-4 px-md-5">
                <div class="row">
                    <div class="col-xl-3"><p>Start your search here</p></div>
                    <div class="col-xl-2 mt-3 mt-lg-0">
                        <select class="form-control form-control-lg w-100 rounded" id="search_country" name="country">
                            <option value="">Select Country</option>
                            @if(count($data['countries']))
                            @foreach($data['countries'] as $country)
                            <option data-cities="{{$country->city_list}}" value="{{ $country->slug }}" {{ $country->slug == $selected_country?'selected':''}}>{{$country->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-xl-2 mt-3 mt-lg-0">
                        <select class="form-control form-control-lg w-100 rounded" id="search_city" name="city">
                            <option selected value="">Select City</option>
                            <!-- @if(count($data['cities']))
                            @foreach($data['cities'] as $city)
                            <option value="{{ strtolower($city->name) }}" {{ strtolower($city->name) == $selected_city?'selected':'' }}>{{ $city->name }}</option>
                            @endforeach
                            @endif -->
                        </select>
                    </div>
                    <div class="col-xl-2 mt-3 mt-lg-0">
                        <select class="form-control form-control-lg w-100 rounded" id="search_category" name="category">
                            <option value="">All Category</option>
                            @if(count($data['categories']))
                            @foreach($data['categories'] as $category)
                            <option value="{{ $category->slug }}" {{ $category->slug == $selected_category?'selected':''}}>{{$category->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-xl-2 mt-3 mt-lg-0">
                        <button type="submit" class="btn px-5 w-100 btn--search" disabled>Search</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- ~./ Search panel -->
</section>

<section class="container mt-5 mb-5">
	<div class="row" >
        @forelse($data['ads'] as $ad)
        @php
        $featured = '';
        @endphp
		<div class="mb-4 col-12 {{$featured}} ">
			<div class="card adverts_single rounded-0 {{$ad->is_highlight == true?'highlight':''}}">
                <div class="row">
                    <div class="col-lg-3 ad-list-img">
                        <a href="{{ route('ad.detail',[$ad->slug]) }}">
                        <div style="background-image:url('{{ asset('storage/'.$ad->images[0]->image) }}');" class="list-image">
                            <img class="image-width-height-0" src="{{ asset('storage/'.$ad->images[0]->getResizeImage('medium')) }}">
                            @if($ad->package_type == 'featured')
                            <div class="ad-holder__user-badge">Featured</div>
                            @endif
                        </div>
                        </a>
                        @if($ad->is_new == true)
                        <div class="profile_new"></div>
                        @endif
                    </div>
                    <div class="col-lg-9">
                        <div class="addlist-inner">
                            <a href="{{ route('ad.detail',[$ad->slug]) }}"><h4 class='pb-2'>
                            {{ (strlen($ad->title)>33)? substr(strip_tags($ad->title),0,33)."...": $ad->title }}
                            </h4>
                            </a>
                            <p class='adverts_single__price pl-0'>£{{$ad->price}}</p> 
                            <p>{{ (strlen($ad->description)>600)? substr(strip_tags($ad->description),0,600)."...": $ad->description }}</p>
                            <div class="adlist-tag">
                                <form action="{{route('process-search')}}" method="post" id="category-search-form-{{$ad->id}}" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="category" value="{{$ad->category->slug}}">
                                    <input type="hidden" name="city" value="{{ Session::get('city') }}">
                                    <input type="hidden" name="country" value="{{ Session::get('country') }}">
                                </form>
                                <p class="adverts_single__tag d-inline-block adverts_single__tag__cat"><a href="javascript:void(0);" class="category-search" ad-id="{{$ad->id}}">{{ $ad->category->name }}</a></p>
                                <form action="{{route('process-search')}}" method="post" id="location-search-form-{{$ad->id}}" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="city" value="{{ strtolower($ad->city) }}">
                                    <input type="hidden" name="country" value="{{ Session::get('country') }}">
                                    <input type="hidden" name="category" value="{{ Session::get('category') }}">
                                </form>
                                <p class="adverts_single__tag d-inline-block"><a href="javascript:void(0);" class="location-search" ad-id="{{$ad->id}}">{{ $ad->city }}</a></p>
                            </div> 
                        </div>
                    </div>
                </div>
			</div>
		</div>
        @empty
        <div class="col-12">
            <h4 class="text-center">No matching ads found. Please refine your search.</h4>
        </div>
        @endforelse
        <div class="col-12">
        {{ $data['ads']->render() }}
        </div>
	</div>
</section>
@if(!empty($page))
<section class="container admin-panel">
    <div class="admin-panel__bar">
        <h4 class="text-white">{!! $page->cms_title !!}</h4>
    </div>
</section>
<section class="container">
	{!! $page->cms_description !!}
</section>
@endif
@endsection
@push('scripts')
<script type="text/javascript">

    $('.category-search').on('click',function(){
        var val = $(this).attr('ad-id');
        $('#category-search-form-'+val).submit();
    });

    $('.location-search').on('click',function(){
        var val = $(this).attr('ad-id');
        $('#location-search-form-'+val).submit();
    });

    $('#search_country').on("change",function(){
        if ($(this).val() != ""){
            var citiesArr = [];
            var citiesStr = $(this).find('option:selected').data("cities");
            
            citiesArr = (citiesStr != "" ? citiesStr.split(",") : '');
            var optHtml = '<option value="">Select City</option>';
            for(var i=0; i<citiesArr.length; i++){
                optHtml += '<option value="'+citiesArr[i].toLowerCase()+'">'+citiesArr[i]+'</option>';
            }
            $('#search_city').html(optHtml);
        }else{
            var optHtml = '<option disabled selected value>Select City</option>'
			$('#search_city').html(optHtml);
            $(".btn--search").attr('disabled', true);
        }
    });

    $(document).ready(function(){
        var selected_city = "<?php echo $selected_city;?>";
        var citiesArr = [];
        var citiesStr = $('#search_country').find('option:selected').data("cities");
        
        citiesArr = (citiesStr != "" ? citiesStr.split(",") : '');
        var optHtml = '<option value="">Select City</option>';
        for(var i=0; i<citiesArr.length; i++){
            optHtml += '<option value="'+citiesArr[i].toLowerCase()+'" '+(citiesArr[i].toLowerCase() == selected_city?"selected":"")+'>'+citiesArr[i]+'</option>';
        }
        $('#search_city').html(optHtml);

        if ($("#search_city").val() != ""){
            $(".btn--search").attr('disabled', false);
        }else{
            $(".btn--search").attr('disabled', true);
            /* var exists = 0 != $('#search_category option[value='+selected_city+']').length;
            if(exists){
                $("#search_category").val(selected_city);
            } */
        }
    });

    $(document).on("change", "#search_city", function(){
        if ($(this).val() != ""){
            $(".btn--search").attr('disabled', false);
        } else{
            $(".btn--search").attr('disabled', true);
        }
    });
</script>
@endpush