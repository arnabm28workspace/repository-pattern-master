@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
@push('styles')
<style type="text/css">
  .error-cls{
        color: #ff0000;
        font-size: 12px;
        font-weight: 400;
        display: none;
    }
    .slider {
        width: 100%;
        margin: 0 auto;
    }

    .slick-slide {
      margin: 0;
    }

    .slick-slide img {
      width: 100%;
    }

    .slick-prev:before,
    .slick-next:before {
      color: black;
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
    .slider-nav .slick-slide{
        margin: 10px 4px 0;
    }

    .vertical-center-4 {
        opacity: 0;
        visibility: hidden;
        transition: opacity 1s ease;
        -webkit-transition: opacity 1s ease;
    }

    .vertical-center-4.slick-initialized {
        visibility: visible;
        opacity: 1;    
    }
    
    @media (min-width: 992px){
        .slider-bx .slick-dots{
            height: 0;
            overflow: hidden;
        }
    }
    
</style>
@endpush
<section class="container page_intro xs-top-spc xs-top-spc-breadcrumbs">
    {{ Breadcrumbs::render('ad-detail',$data) }}
</section>
<section class="container profile mb-5">
    <div class="row">
<!--
        <div class="col-12 mb-3 profile_back">
            <div class="pl-3"><a href="{{ URL::previous() }}"><i class="fa fa-long-arrow-left"></i> Back </a></div>
        </div>
-->
        <div class="col-12 col-xl-7">
            <div class="card py-4 px-xl-5 pb-5">
                <div class="px-xl-4 container">
                    <div class="row">
                        <div class="col-10 pl-md-1"><h1 class="h1 pl-1 pl-md-4 pl-lg-0">{{$data['ad']->title}}</h1></div>
                        <!-- <div class="col-2 pr-1"><h5 class="h1 font-weight-bold text-right">£{{$data['ad']->price}}</h5></div> -->
                        <div class="col-12 pb-3 pl-md-1"></div>
                    </div>
                    <div class="row slider-bx">
                       <div class="col-12">
                        <section class="vertical-center-4 slider">
                            @foreach($data['ad']->images as $image)
                            <div class="col-12 px-1">
                                <div class="profile_new"></div>
                                <img src="{{ asset('storage/'.$image->image) }}" alt="" class="">
                            </div>
                            @endforeach
                        </section>
                        <section class="slider-nav slider">
                            @foreach($data['ad']->images as $image)
                            <div class="slider-thumb">
                                <img src="{{ asset('storage/'.$image->getResizeImage('medium')) }}" alt="" class="">
                            </div>
                            @endforeach
                        </section>
                        </div>
                    </div>
               </div>
            </div>
            <div class="card table-card">
                <table class="table-card-full table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                        <tbody>
                            <tr>
                                <td class="font-weight-bold">City</td>
                                <td>{{$data['ad']->country->name}}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">City</td>
                                <td>{{$data['ad']->city}}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Type</td>
                                <td>{{ $data['ad']->type == 1 ? 'Independent':'Agency' }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Price</td>
                                <td>{{App\Models\Setting::get('currency_symbol').ucwords( $data['ad']->price) }}</td>
                            </tr>
                            @if (count($data['ad']->ad_details))
                            @foreach($data['ad']->ad_details as $detail)
                            @if($detail->type == 'normal')
                            <tr>
                                <td class="font-weight-bold">{{ $detail->key }}</td>
                                <td>{{ ucwords($detail->value) }}</td> 
                            </tr>
                            @elseif($detail->type == 'rate')
                            <tr>
                                @php
                                $rates = json_decode($detail->value);
                                @endphp
                                @if(isset($rates) && count($rates)>0)
                                <td class="font-weight-bold">Rates</td>
                                <td class="rate-table">
                                    <table class="table inner-table">
                                        <thead>
                                            <th>Time</th>
                                            <th>Incall</th>
                                            <th>Outcall</th>
                                        </thead>
                                        <tbody>
                                        @foreach($rates[2]->val as $key=>$v)
                                        <tr>
                                            <td>{{ $v }}</td>
                                            <td>{{(isset($rates[0]->val[$key]) && $rates[0]->val[$key]!='')?'£'.$rates[0]->val[$key]:'NA'}}</td>
                                            <td>{{(isset($rates[1]->val[$key]) && $rates[1]->val[$key]!='')?'£'.$rates[1]->val[$key]:'NA'}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </td>
                                @endif
                            </tr>
                            @endif
                            @endforeach
                            @endif
                            <tr>
                                <td class="font-weight-bold">Description</td>
                                <td>{{ $data['ad']->description }}</td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </div>
        <div class="col-12 col-xl-5 mt-5 mt-lg-0">
            <div class="card profile_contact">
              @include('site.partials.flash')
                <div class="js-contact-me">
                    <h4 class="font-weight-bold text-capitalize text-center px-5 cont-me">Contact me</h4>
                    <div class="pl-4 pl-md-5 pr-4 pr-md-5 contact-me">
                        <a href="tel:{{$data['ad']->phone}}" class="cal-ico btn w-100 py-3 mb-4"><i class="fas fa-phone"></i>Call Me</a>
                        <a href="javascript:void();" class="msg-ico btn w-100 py-3 mb-4 js-open-message-form"><i class="fas fa-envelope"></i>Message Me</a>

                        <a href="{{$data['ad']->website}}" class="web-ico btn w-100 mb-4 py-3 "><i class="fas fa-globe"></i>Website</a>
                        <a href="javascript:void();" class="report-ico btn w-100 py-3 mb-4 js-open-report-form"><i class="fas fa-file-alt"></i>Report Abuse</a>
                    </div>
                    <p class="px-5 py-4 text-center text-md-left">Ad ID {{$data['ad']->unique_id}}</p>
                </div>

                <div class="js-message-me" style="display:none;">
                    <h4 class="font-weight-bold text-capitalize text-center px-5 mt-4">Message me</h4>
                        <div class="px-4 px-md-5">
                          
                            <form class="" action="{{route('storeadmessage')}}" method="post">
                                @csrf
                                <input type="hidden" name="ad_id" value="{{$data['ad']->id}}">
                                <div class="row pt-5 pb-3">
                                    <div class="col-12 py-2 form-field">
                                        <label>Your email address</label>
                                        <input type="text" name="email" id="email">
                                        <p class="error-cls email-error">Please enter email id</p>
                                    </div>
                                    <div class="col-12 py-2 form-field">
                                        <label>Your phone number</label>
                                        <input type="tel" name="phone" id="phone">
                                        <p class="error-cls phone-error">Please enter phone no</p>
                                    </div>
                                    <div class="col-12 py-2 form-field">
                                        <label>Subject</label>
                                        <input type="text" name="subject" id="subject">
                                        <p class="error-cls subject-error">Please enter subject</p>
                                    </div>
                                    <div class="col-12 py-2">
                                        <label>Message</label>
                                        <textarea name="message" id="message"></textarea>
                                        <p class="error-cls message-error">Please enter message</p>
                                    </div>
                                    <div class="col-6 col-md-12 col-lg-6 py-2">
                                        <input class="mt-3 w-100 mw-100" type="submit" value="Submit" id="sendMessage">
                                    </div>
                                    <div class="col-6 col-md-12 col-lg-6 py-2">
                                        <a href="javascript:void();" class="btn btn--xs btn--gray mt-3 js-close-form">Close</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                </div>
                <div class="js-report-me" style="display:none;">
                    <h4 class="font-weight-bold text-capitalize text-center px-5 mt-4">Report This Ad</h4>
                        <div class="px-5">
                          @include('site.partials.flash')
                            <form class="" action="{{route('storereportabuse')}}" method="post">
                                @csrf
                                <input type="hidden" name="ad_id" value="{{$data['ad']->id}}">
                                <div class="row pt-5 pb-3">
                                    <div class="col-12 py-2">
                                        <label><strong>Reason</strong></label>
                                        <textarea name="reason"></textarea>
                                        <p class="error-cls message-error">Please enter report reason</p>
                                    </div>
                                    <div class="col-6 col-md-12 col-lg-6 py-2">
                                        <input class="mt-3 w-100 mw-100" type="submit" value="Submit" id="reportPost">
                                    </div>
                                    <div class="col-6 col-md-12 col-lg-6 py-2">
                                        <a href="javascript:void();" class="btn btn--xs btn--gray mt-3 js-close-form1">Close</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
    
</section>
@endsection
