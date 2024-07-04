@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<section class="home__hero" style="background-image:url({!!asset('frontend/images/hero_lg.jpg')!!});">
	<!-- Search panel -->
    <form action="{{ route('process-search') }}" method="post">
    @csrf
        <input type="hidden" name="search_from" value="search" />
        <div class="c-search-block d-flex justify-content-center">
            <div class="c-search-block__inner col-xl-9 py-5 px-4 px-md-5">
                <div class="row">
                    <div class="col-xl-3"><p>Start your search here</p></div>
                    <div class="col-xl-2 mt-3 mt-lg-0">
                        <select class="form-control form-control-lg w-100 rounded" id="search_country" name="country">
                            <option value="">Select Country</option>
                            @if(count($datas['countries']))
                            @foreach($datas['countries'] as $country)
                            <option data-cities="{{$country->city_list}}" value="{{ $country->slug }}" {{ $country->slug == $selected_country?'selected':''}}>{{$country->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-xl-2 mt-3 mt-lg-0">
                        <select class="form-control form-control-lg w-100 rounded" id="search_city" name="city">
                            <option selected value="">Select City</option>
                            <!-- @if(count($datas['cities']))
                            @foreach($datas['cities'] as $city)
                            <option value="{{ strtolower($city->name) }}">{{$city->name}}</option>
                            @endforeach
                            @endif -->
                        </select>
                    </div>
                    <div class="col-xl-2 mt-3 mt-lg-0">
                        <select class="form-control form-control-lg w-100 rounded" name="category" id="search_category">
                            <option value="">All Category</option>
                            @if(count($datas['categories']))
                            @foreach($datas['categories'] as $category)
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

<section class="home__latest pt-4">
    <h3 class="my-2 my-lg-4 text-uppercase pb-3">Our latest ads</h3>
    <div class="home-slider slide">
    @forelse($datas['ads'] as $ad)
        <div class="slick-innar-wrap">
            <div class="slick-innar-col {{$ad->is_highlight == true?'highlight':''}}">
                <a href="{{ route('ad.detail',[$ad->slug]) }}">
                    <div style="background-image:url('{{ asset('storage/'.$ad->images[0]->getResizeImage('medium')) }}');" class="slick-innar-image">
                        <img class="image-width-height-0" src="{{ asset('storage/'.$ad->images[0]->getResizeImage('medium')) }}">
                        <div class="profile_new"></div>
                    </div>
                </a>
                <div class="home-description px-4 py-4">
                    <a href="{{ route('ad.detail',[$ad->slug]) }}"><h4 class="pb-2">{{ (strlen($ad->title)>20)? substr($ad->title,0,20)."...": $ad->title }}</h4></a>
                    <p>{{(strlen($ad->description)>60)? substr(strip_tags($ad->description),0,60)."...": $ad->description}}</p>
                    <p class="adverts_single__price pl-0">Price: £{{ $ad->price }}</p>
                    <div class="adlist-tag">
                        <form action="{{route('process-search')}}" method="post" id="category-search-form-{{$ad->id}}" style="display: none;">
                            @csrf
                            <input type="hidden" name="category" value="{{$ad->category->slug}}">
                        </form> 
                        <p class="adverts_single__tag d-inline-block adverts_single__tag__cat"><a href="javascript:void(0);" class="category-search" ad-id="{{$ad->id}}">{{ $ad->category->name }}</a></p>
                        <form action="{{route('process-search')}}" method="post" id="location-search-form-{{$ad->id}}" style="display: none;">
                            @csrf
                            <input type="hidden" name="city" value="{{ strtolower($ad->city) }}">
                        </form>
                        <p class="adverts_single__tag d-inline-block"><a href="javascript:void(0);" class="location-search" ad-id="{{$ad->id}}">{{ $ad->city }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    @empty
    <p>No such latest ads</p>
    @endforelse
    </div>
    @if (count($datas['ads']) > 0)
    <div class="text-center view-more-btn">
        <a href="{{ route('ad-list') }}" class="btn px-5 ml-3 text-capitalize">View All Ads</a>
    </div>
    @endif
</section>
@endsection
@push('styles')
<style>
    .slider {
        width: 50%;
        margin: 100px auto;
    }

    .slick-slide {
      margin: 0px 20px;
    }

    .slick-slide img {
      width: 100%;
    }

    .slick-prev:before,
    .slick-next:before {
      color: black;
    }

    .slick-next {
        right: 0 !important;
    }

    .slick-prev {
        left: -15px !important;
    }


    .slick-slide {
      transition: all ease-in-out .3s;
      opacity: .2;
    }
    
    .slick-active {
      opacity: .5;
    }

    .slick-current {
      opacity: 1;
    }

    .home-slider {
            opacity: 0;
            visibility: hidden;
            transition: opacity 1s ease;
            -webkit-transition: opacity 1s ease;
    }
    .home-slider.slick-initialized {
        visibility: visible;
        opacity: 1;    
    }

</style>
@endpush
@push('scripts')
<script type="text/javascript">
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
            var exists = 0 != $('#search_category option[value='+selected_city+']').length;
            if(exists){
                $("#search_category").val(selected_city);
            }
        }
    });

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
            var optHtml = '<option selected value="">Select City</option>';
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

    $(document).on("change", "#search_city", function(){
        if ($(this).val() != ""){
            $(".btn--search").attr('disabled', false);
        } else{
            $(".btn--search").attr('disabled', true);
        }
    });
</script>
@endpush