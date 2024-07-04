@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div class="active-wrap">
                <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
                <div class="form-group">
                    <button class="btn btn-primary" type="button" id="btnSave"><i class="fa fa-check-circle"></i>Update Package</button>
                <a class="btn btn-secondary" href="{{ route('admin.package.index') }}"><i style="vertical-align: baseline;" class="fa fa-chevron-left"></i>Back</a>
              </div>
            </div>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-12 mx-auto">
            <div class="tile">
                <form action="{{ route('admin.package.update') }}" method="POST" role="form" enctype="multipart/form-data" id="form1">
                    @csrf
                    <div class="tile-body form-body">
                    <div class="form-group">
                      <label>Package Type<span style="color:red; font-size:55%">★</span></label>
                        @if($package->package_type == "basic_package")
                        <select name="package_type" id="package_type" class="form-control package_type" style="width: 100%;" readonly>
                            <option value="basic_package" selected>Basic Package</option>
                        @else
                        <select name="package_type" id="package_type" class="form-control package_type" style="width: 100%;">
                            <option value="basic_package">Basic Package</option>
                            <option value="add_on" selected>Add On</option>
                        @endif
                      </select>
                      <small>Once you have changed add on to the basic package you'll not be able to update package type</small>
                    </div>
                    <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ $package->name }}"/>
                            @error('name') {{ $message }} @enderror
                            <input type="hidden" name="id" value="{{ $package->id }}">
                        </div>
                        <div class="input_fields_wrap">
                            <label class="control-label" for="tenure">Tenure <span class="m-l-5 text-danger"> *</span></label><br/>
                        <?php
                        $i=0;
                            if(count($package->package_duration_price) == 0)
                            {
                            ?>
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <input type="text" name="duration[]" class="form-control @error('duration.0') is-invalid @enderror" placeholder="Duration in day(s)">
                                        @error('duration.0') {{ $message }} @enderror
                                    </div>
                                    <div class="form-group col-md-5">
                                        <input type="text" name="price[]" class="new form-control @error('price.0') is-invalid @enderror"  placeholder="Price">
                                        @error('price.0') {{ $message }} @enderror
                                    </div>
                                    <div class="form-group col-md-2">
                                    <div class="add_field_button"><i class="fa fa-plus"></i></div>
                                    </div>
                                </div>
                            <?php
                            }else{
                                 foreach ($package->package_duration_price as $package_duration_price) 
                                 { 
                                     if($i>0)
                                     { ?>
                                         <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <input class="form-control @error('duration.0') is-invalid @enderror" type="text" name="duration[]" value = "<?php echo $package_duration_price['duration']; ?>" placeholder="Duration in day(s)">
                                                @error('duration.0') {{ $message }} @enderror
                                            </div>
                                            <div class="form-group col-md-5">
                                                <input class="form-control @error('price.0') is-invalid @enderror" type="text" name="price[]" value = "<?php echo $package_duration_price['price']; ?>" placeholder="Price">
                                                @error('price.0') {{ $message }} @enderror
                                            </div>
                                            <div class="form-group col-md-2">
                                            <div class="remove_field"><i class="fa fa-minus"></i></div>
                                            </div>
                                        </div>

                                     <?php }else{ ?>
                                         
                                         <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <input class="form-control @error('duration.0') is-invalid @enderror" type="text" name="duration[]" value = "<?php echo $package_duration_price['duration']; ?>" placeholder="Duration in day(s)">
                                                @error('duration.0') {{ $message }} @enderror
                                            </div>
                                            <div class="form-group col-md-5">
                                                <input class="form-control @error('price.0') is-invalid @enderror" type="text" name="price[]" value = "<?php echo $package_duration_price['price']; ?>" placeholder="Price">
                                                @error('price.0') {{ $message }} @enderror
                                            </div>
                                            <div class="form-group col-md-2">
                                            <div class="add_field_button"><i class="fa fa-plus"></i></div>
                                            </div>
                                        </div>

                                    <?php }
                                     ?>
                             <?php
                                 $i++; 
                                 }   
                            }
                             
                        ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ $package->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($package->image != null)
                                        <figure class="mt-2" style="height: auto;">
                                            <img src="{{ asset('storage/'.$package->image) }}" id="image" class="img-fluid" alt="img">
                                        </figure>
                                    @else
                                        <figure class="mt-2" style="height: auto;">
                                            <img src="{{ asset('frontend/images/no-image-available.png') }}" id="image" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label">Package Image</label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                                    @error('image') {{ $message }} @enderror
                                    <p><small>Choose new image to replace old image</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group toogle-lg">
                            <label class="control-label">Status</label>
                            <div class="toggle-button-cover">
                                <div class="button-cover">
                                    <div class="button-togglr b2" id="button-11">
                                        <input id="toggle-block" type="checkbox" name="status" class="checkbox" {{ $package->status == 1 ? 'checked' : '' }}>
                                        <div class="knobs"><span>Inactive</span></div>
                                        <div class="layer"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

<script type="text/javascript">
    $(document).ready(function() {
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="form-row"> <div class="form-group col-md-5"> <input class="form-control" type="text" name="duration[]" placeholder="Duration in day(s)"/> </div> <div class="form-group col-md-5"> <input class="form-control" type="text" name="price[]" placeholder="Price"/></div> <div class="form-group col-md-2"> <div class="remove_field"><i class="fa fa-minus"></i></div> </div></div>'); //add input box
            }
        });
        
        $(document).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).closest('.form-row').remove(); x--;
        })

        $(".package_type").change(function() {
            var selectedPackage = $(".package_type option:selected").val();

            if (selectedPackage == "basic_package") {
              alert("Once you have changed add on to the basic package you'll not be able to update package type");
            }
          });

        $("#btnSave").on("click",function(){
            $('#form1').submit();
        })
    });
</script>

@endpush