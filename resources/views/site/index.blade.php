@include('site.partials.header')
<section class="home__hero" style="background-image:url({!!asset('frontend/images/hero_lg.jpg')!!});">
	<!-- Search panel -->
    <form action="{{URL::to('ad-list')}}">
        <div class="c-search-block d-flex justify-content-center">
            <div class="c-search-block__inner col-xl-9 py-5 px-5">
                <div class="row">
                    <div class="col-xl-3"><p>Start your search here</p></div>
                    <div class="col-xl-3">
                        <select class="form-control form-control-lg w-100 rounded" name="category_id">
                            <option selected disabled hidden>Choose Category</option>
                            @if(count($datas['categories']))
                            @foreach($datas['categories'] as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-xl-3">
                        <select class="form-control form-control-lg w-100 rounded" name="country_id">
                            <option selected disabled hidden>Choose Location</option>
                            @if(count($datas['countries']))
                            @foreach($datas['countries'] as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-xl-2">
                         <button type="submit" class="btn px-5 w-100">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- ~./ Search panel -->
</section>
<section class="home__latest pt-4">
    <h3 class="my-4 text-uppercase">Our latest ads</h3>
	<div class="home-carousel owl-carousel owl-theme">
        @if(count($datas['ads']))
        @foreach($datas['ads'] as $ad)
        @if(count($ad->ad_packages)>0 && $ad->ad_packages[0]->expiry_date>= Carbon\Carbon::now()->toDateString())
        @php $key = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $ad->title)); @endphp
        <a class="col-12 item-holder mb-5 px-1 px-lg-2" href="{!! URL::to('ad-details/'.$ad->id.'/'.$key) !!}">
            @if($ad->ad_image[0]->image=='http://placehold.jp/350x350.png')
            <img src="{{ $ad->ad_image[0]->image }}" alt="" class="">
            @else
            <img src="{{ asset('storage/'.$ad->ad_image[0]->getResizeImage('medium')) }}" alt="" class="">
            @endif
            <div class="item-holder_text">
                <div class="item-holder_text text-dark font-weight-light pt-2">{{substr(strip_tags($ad->description),0,100)}}..</div>
                <div class="item-holder_price">£{{$ad->price}}</div>
            </div>
        </a>
        @endif
        @endforeach
        @endif
    </div>
</section>

@include('site.partials.footer')
