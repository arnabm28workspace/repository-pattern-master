@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

<section class="container page_intro xs-top-spc xs-top-spc-breadcrumbs">
    
    {{ Breadcrumbs::render('post-ad') }}
</section>
<section class="container admin-panel mt-4">
    <div class="admin-panel__bar mt-4"><h4 class="text-white">Post Your Advert</h4></div>
    <div class="admin-panel__body1 mt-4">
        <form class="label-bold" action="{{route('adsubmit')}}" method="post">
            @csrf
            <div class="admin-panel__body__form">
<!--               new structute start-->
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 px-0">
                            <div class="mt-4">
                                @include('site.ads.navbar')
                            </div>        
                          <!--details payment nav-->
                              
                          <!--details payment nav-->
                          <div class="pt-3 pb-3 px-1 px-md-4 section-border-outer">
                              <h4 class="mb-0 py-2 pl-3">Advert Details</h4>
                          </div>
                           <div class="pt-3 pb-3 px-1 py-5 px-md-4 py-5 section-border">
                                <div class="row px-3">
                                <div class="col-12 col-lg-4 py-2">
                                    <label><strong>Country</strong></label>
                                    <select name="country_id" id="country_id">
                                        <option value="">Select Country</option>
                                        @if(count($countries))
                                        @foreach($countries as $country)
                                         @if($country->status==1)
                                        <option value="{{$country->id}}" cities="{{$country->city_list}}">{{$country->name}}</option>
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                    <p class="error-cls country-error">Please enter country</p>
                                </div>
                                <div class="col-12 col-lg-4 py-2">
                                    <label><strong>City</strong></label>
                                    <!-- <input type="text" name="city" id="city"> -->
                                    <select name="city" id="city">

                                    </select>
                                    <p class="error-cls city-error">Please enter city</p>
                                </div>
                                <div class="col-12 col-lg-4 py-2">
                        <label for=""><strong>Category</strong></label>
                        <select name="category_id" id="category_id">
                            <option value="">Select Category</option>
                            @if(count($categories))
                            @foreach($categories as $category)
                            @if($category->status==1)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                        <p class="error-cls category-error">Category</p>
                    </div>
                                <div class="col-12 col-lg-6 py-2 form-field">
                        <label><strong>Title</strong></label>
                        <input type="text" name="title" id="title">
                        <p class="error-cls title-error">Please enter ad title</p>
                    </div>
                                <div class="col-12 col-lg-2 py-2 form-field">
                        <label><strong>Price</strong></label>
                        <input type="text" name="price" id="price">
                        <p class="error-cls title-error">Please enter ad price</p>
                    </div>
                                <div class="col-12 col-lg-4 py-2">
                        <label for=""><strong>Type</strong></label>
                        <select name="type" id="type">
                            <option value="">Select Type</option>
                            <option value="1">Independent</option>
                            <option value="2">Agency</option>
                        </select>
                        <p class="error-cls type-error">Please enter your type</p>
                    </div>
                                <div class="col-12 pt-2 form-field">
                        <label><strong>Description</strong></label>
                        <textarea name="description" id="desc"></textarea>
                        <p class="error-cls desc-error">Please enter ad description</p>
                    </div>
                                <div class="col-12 py-2">
                       <label><strong>Upload Photos</strong></label>
                        <div id ="dropzone" class="dropzone upload-photo">
                            <div class="file-up dz-message">
                                <span class="faicons" style="background-image:url({!!asset('frontend/images/file.png')!!});">
                                </span>
                                <h3>Drag files Here
                                <span><i>or</i> click to browse your files</span>
                                </h3>
                            </div> 
                        </div>
                    </div>
                                <p class="error-cls img-error">Please add at least one image</p>
                                <div class="container-inner container pl-md-0">
                        <div class="row w-100 px-0 px-md-4 pt-0 pb-3" id="category_field">
                        </div>
                    </div>
                            </div>
                            </div>
                             <div class="pt-3 pb-3 px-1 px-md-4 section-border-outer">
                              <h4 class="mb-0 py-2 pl-4">Personal Details</h4>
                             </div>
                            <div class="admin-panel__body">
                                <div class="row px-4 px-md-5 py-5">
                                    <div class="col-12 col-lg-4 py-2 form-field">
                                        <label><strong>Phone</strong></label>
                                        <input type="text" name="phone" placeholder="this will be displayed in your ad" id="phone" value="{{$profile->phone_number}}">
                                        <p class="error-cls phone-error">Please enter phone no</p>
                                    </div>
                                    <div class="col-12 col-lg-4 py-2 form-field">
                                        <label><strong>Email</strong></label>
                                        <input type="text" name="email" id="email" value="{{$user_email}}">
                                        <p class="error-cls email-error">Please enter email id</p>
                                    </div>
                                    <div class="col-12 col-lg-4 py-2 form-field">
                                        <label><strong>Website</strong></label>
                                        <input type="text" name="website" id="website" value="{{$profile->website_url}}">
                                        <p class="error-cls website-error">Please enter website</p>
                                    </div>
                                    <div class="col-12 mt-5 ">
                                        <label style="width:100%;" class=" mw-100 check-container">I agree to <a href=" ">Terms and Conditions</a>
                                            <input type="checkbox" checked="checked">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <input type="hidden" class="doc" name="document[]" value="">
                                    <div class="col-12">
                                        <label style="width:100%;" class="mw-100 check-container ">I have read and accept <a href=" ">Privacy Policy</a>
                                            <input type="checkbox" checked="checked">
                                            <span class="checkmark"></span>
                                        </label>
                                        <input class="mt-3" type="submit" value="Post Ad" id="postAd">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-md-block">
                            <div class="row section-border ml-md-3 pt-3 pb-3 mt-4">
                                <div class="col mt-4 right-pan">
                                    <div class="px-3">
                                        <h4 class="pb-2" id="side_widget_category_title"></h4>
                                        <div class="list-items mb-4" id="side_widget_category_description">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!--                new structute start end-->
            </div>
            
        </form>
    </div>
</section>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var category_id = $('#category_id').val();
        if(!category_id)
        {
            var side_widget_title = "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s";
            var side_widget_description = "<li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li><li>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</li><li>The generated Lorem Ipsum is therefore always free from repetition</li>"
            $('#side_widget_category_title').text(side_widget_title);
            $('#side_widget_category_description').html(side_widget_description);
            $( "#side_widget_category_description li" ).prepend("<i class='fas fa-check'></i>");
        }
    });
    $('#category_id').on("change",function(){
        var category_id = $(this).val();
        var CSRF_TOKEN = $("input[name=_token]").val();
        if(category_id)
        {
           $.ajax({
                 type:'POST',
                 dataType:'JSON',
                 url:"{{route('user.customform.getCategoryFields')}}",
                 data:{ _token: CSRF_TOKEN, category_id:category_id},
                 success:function(response)
                 {
                   createField(response);
                 },
                 error: function(response)
                 {
                     //console.log(response);
                 }
               });
           $.ajax({
                 type:'POST',
                 dataType:'JSON',
                 url:"{{route('user.customform.getCategoryDetails')}}",
                 data:{ _token: CSRF_TOKEN, category_id:category_id},
                 success:function(response)
                 {
                   $('#side_widget_category_title').text(response.name);
                   $('#side_widget_category_description').html(response.description);
                   $( "#side_widget_category_description li" ).prepend("<i class='fas fa-check'></i>");
                 },
                 error: function(response)
                 {
                     // console.log(response);
                 }
               }); 
       }else{

            var side_widget_title = "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s";
            var side_widget_description = "<li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</li><li>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</li><li>The generated Lorem Ipsum is therefore always free from repetition</li>"
            $('#side_widget_category_title').text(side_widget_title);
            $('#side_widget_category_description').html(side_widget_description);
            $( "#side_widget_category_description li" ).prepend("<i class='fas fa-check'></i>");
       }
        
    });
</script>
<script type="text/javascript" src="{{ asset('frontend/js/customform.js') }}"></script>
@endsection
@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('backend/js/plugins/dropzone/dist/min/dropzone.min.css') }}"/>
@endpush
@push('scripts')    
<script type="text/javascript" src="{{ asset('backend/js/plugins/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#dropzone", {
            maxFilesize: 12,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 5000,
            url: "dropzone-store",
            success: function(file, response) {
                console.log(response);
                $('form').append('<input type="hidden" class="doc" name="document[]" value="' + response.name + '">')
            }
        });

        /* myDropzone = {
            maxFilesize: 12,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 5000,
            success: function(file, response) {
                console.log(response);
            },
        }; */

    </script>

@endpush