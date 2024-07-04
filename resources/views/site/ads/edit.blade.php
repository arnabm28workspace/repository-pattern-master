@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
@push('styles')
<style type="text/css">
.dz-filename{
    display:none;
}
.dz-size{
    display: none;
}
</style>
@endpush
<section class="container page_intro xs-top-spc xs-top-spc-breadcrumbs">
    
    {{ Breadcrumbs::render('edit-ad',$data) }}
</section>
<section class="container admin-panel mt-4">
    <div class="admin-panel__bar mt-4"><h4 class="text-white">Edit Your Advert</h4></div>
        <div class="admin-panel__body1 mt-5">
        <form class="label-bold" action="{{route('updateads')}}" method="post">
            <input type="hidden" name="id" id="ad_id" value="{{$data['ad']->id}}">
            <input type="hidden" name="unique_id" value="{{$data['ad']->unique_id}}">
            <input type="hidden" name="package_id" value="{{$data['ad']->package_id}}">
            @csrf
            <div class="admin-panel__body__form">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 px-0">@include('site.ads.navbar')
                           <div class="pt-3 pb-3 px-1 px-md-4 section-border-outer">
                              <h4 class="mb-0 py-2 pl-3">Edit Advert details</h4>
                           </div>
                            <div class="pt-3 pb-3 px-1 px-md-4 py-5 section-border">
                                <div class="row px-3">
                                    <div class="col-12 col-lg-4 py-2">
                                        <label><strong>Country</strong></label>
                                        <select name="country_id" id="country_id">
                                            <option value="">Select Country</option>
                                            @if(count($data['countries']))
                                            @foreach($data['countries'] as $country)
                                            <option value="{{$country->id}}" <?php if($data['ad']->country_id==$country->id){echo "selected";}?> cities="{{$country->city_list}}">{{$country->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <p class="error-cls country-error">Please Choose country</p>
                                    </div>
                                    <div class="col-12 col-lg-4 py-2">
                                        <label><strong>City</strong></label>
                                        <select name="city" id="city">

                                        </select>
                                        <p class="error-cls city-error">Please enter city name</p>
                                    </div>
                                    <div class="col-12 col-lg-4 py-2">
                                        <label for=""><strong>Category</strong></label>
                                        <select name="category_id" id="category_id">
                                            <option value="">Select Category</option>
                                            @if(count($data['categories']))
                                                @foreach($data['categories'] as $category)
                                                    <?php 
                                                    if($data['ad']->category_id == $category->id)
                                                    { ?>
                                                    <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                                    <?php 
                                                    }else{
                                                    ?>
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                    <?php 
                                                    }
                                                    ?>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p class="error-cls category-error">Please Choose category</p>
                                    </div>
                                    <div class="col-12 col-lg-6 py-2 form-field">
                                        <label><strong>Title</strong></label>
                                        <input type="text" name="title" id="title" value="{{ $data['ad']->title }}">
                                        <p class="error-cls title-error">Please enter ad title</p>
                                    </div>
                                    <div class="col-12 col-lg-2 py-2 form-field">
                                        <label><strong>Price</strong></label>
                                        <input type="text" name="price" id="price" value="{{ $data['ad']->price }}">
                                        <p class="error-cls title-error">Please enter ad price</p>
                                    </div>
                                    <div class="col-12 col-lg-4 py-2">
                                        <label for=""><strong>Type</strong></label>
                                        <select name="type" id="type">
                                            <option value="">Select Type</option>
                                            <option value="1" <?php if($data['ad']->type=='1'){echo "selected";}?>>Independent</option>
                                            <option value="2" <?php if($data['ad']->type=='2'){echo "selected";}?>>Agency</option>
                                        </select>
                                        <p class="error-cls type-error">Please enter your type</p>
                                    </div>
                                    <div class="col-12 py-2">
                                        <label><strong>Description</strong></label>
                                        <textarea name="description" id="desc">{{$data['ad']->description}}</textarea>
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
                              <h4 class="mb-0 py-2 pl-4">Personal details</h4>
                             </div>
                            <div class="admin-panel__body">
                                <div class="row px-4 px-md-5 py-5">
                                    <div class="col-12 col-lg-4 py-2 form-field">
                                        <label><strong>Phone</strong></label>
                                        <input type="text" name="phone" placeholder="this will be displayed in your ad" id="phone" value="{{$data['ad']->phone}}">
                                        <p class="error-cls phone-error">Please enter phone no</p>
                                    </div>
                                    <div class="col-12 col-lg-4 py-2 form-field">
                                        <label><strong>Email</strong></label>
                                        <input type="text" name="email" id="email" value="{{$data['ad']->email}}">
                                        <p class="error-cls email-error">Please enter email id</p>
                                    </div>
                                    <div class="col-12 col-lg-4 py-2 form-field">
                                        <label><strong>Website</strong></label>
                                        <input type="text" name="website" id="website" value="{{$data['ad']->website}}">
                                        <p class="error-cls website-error">Please enter website</p>
                                    </div>
                                    <div class="col-12 mt-5 ">
                                        <label style="width:100%;" class=" mw-100 check-container">I agree to <a href=" ">Terms and Conditions</a>
                                            <input type="checkbox" checked="checked">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="col-12">
                                        <label style="width:100%;" class="mw-100 check-container ">I have read and accept <a href=" ">Privacy Policy</a>
                                            <input type="checkbox" checked="checked">
                                            <span class="checkmark"></span>
                                        </label>
                                        <input class="mt-3" type="submit" value="Save" id="postAd">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-md-block">
                            <div class="row section-border ml-md-3 pt-3 pb-3">
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
            </div>
        </form>
    </div>
</section>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    var fetchValueUrl = "{{route('ads.customform.getValues')}}";
    var fetchRateUrl = "{{route('ads.customform.getRateValues')}}";
    var CSRF_TOKEN = $("input[name=_token]").val();
    $(document).ready(function(){
        var citiesArr = [];
        var citiesStr = $('#country_id').find('option:selected').attr("cities");
        citiesArr = citiesStr.split(",");
        var optHtml = '';
        for(var i=0;i<citiesArr.length;i++){
            optHtml += '<option value="'+citiesArr[i]+'">'+citiesArr[i]+'</option>';
        }

        $('#city').html(optHtml);
        $("#city").val("{{$data['ad']->city}}").attr("selected","selected");

        var category_id = $('#category_id').val();
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
                      console.log(response);
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
                     console.log(response);
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
        var ad_id = $('#ad_id').val();
        var get_image_url = "{{URL::to('get-images')}}"+"/"+ad_id;
        var update_image_url = "{{URL::to('update-image')}}";
        var delete_image_url = "{{URL::to('delete-image')}}";

        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#dropzone", {
            url: "{{URL::to('dropzone-update')}}",
            addRemoveLinks: true,
            
            success: function(file, response) {
                console.log(response);
                updateImage(response.name);
                //$('form').append('<input type="hidden" class="doc" name="document[]" value="' + response.name + '">')
            },
            init:function(){
                let myDropzone = this;
                $.ajax({
                    type:'GET',
                    dataType:'JSON',
                    url:get_image_url,
                    data:{ _token: CSRF_TOKEN},
                    success:function(response)
                    {
                        for(var i=0;i<response.images.length;i++){
                            let mockFile = { name: response.images[i].original_name};
                            myDropzone.options.addedfile.call(myDropzone, mockFile);
                            myDropzone.options.thumbnail.call(myDropzone, mockFile, response.images[i].url);
                            myDropzone.options.complete.call(myDropzone, mockFile);
                        }
                        
                    },
                    error: function(response)
                    {
                        console.log(response);
                    }
                });
            },
            timeout: 50000,
            removedfile: function(file) 
            {
                var name = file.name; 
                //alert(name);
                deleteImage(name);

                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
        });

        function updateImage(name){
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: update_image_url,
                data: {
                    _token: CSRF_TOKEN,
                    ad_id: ad_id,
                    image: name
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }

        function deleteImage(name){
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: delete_image_url,
                data: {
                    _token: CSRF_TOKEN,
                    ad_id: ad_id,
                    image: name
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }
    </script>
@endpush