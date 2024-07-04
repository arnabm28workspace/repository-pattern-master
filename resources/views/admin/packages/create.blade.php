@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div class="active-wrap">
                <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
                <div class="form-group">
                    <button class="btn btn-primary" type="button" id="btnSave"><i class="fa fa-check-circle"></i>Save Package</button>
                    <a class="btn btn-secondary" href="{{ route('admin.package.index') }}"><i style="vertical-align: baseline;" class="fa fa-chevron-left"></i>Back</a>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-12 mx-auto">
            <div class="tile">
                <form action="{{ route('admin.package.store') }}" method="POST" role="form" enctype="multipart/form-data" id="form1">
                    @csrf
                    <div class="tile-body form-body">
                        <div class="form-group">
                          <label>Package Type<span style="color:red; font-size:55%">★</span></label>
                          <select name="package_type" id="package_type" class="form-control" style="width: 100%;">
                              <option value="basic_package">Basic Package</option>
                              <option value="add_on">Add On</option>
                          </select>
                          <small>Once you select the basic package you'll not be able to update package type and delete the package</small>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}"/>
                            @error('name') {{ $message }} @enderror
                        </div>
                        <div class="form-group input_fields_wrap">
                            <label class="control-label" for="tenure">Tenure <span class="m-l-5 text-danger"> *</span></label><br/>
                            
                            <div class="form-row">
                            <div class="form-group col-md-5">
                              <input type="text" class="form-control @error('duration.0') is-invalid @enderror" name="duration[]" placeholder="Duration in day(s)">
                              @error('duration.0') {{ $message }} @enderror
                            </div>
                            <div class="form-group col-md-5">
                             <input type="text" name="price[]" class="form-control @error('price.0') is-invalid @enderror" placeholder="Price">
                             @error('price.0') {{ $message }} @enderror
                            </div>
                            <div class="form-group col-md-2">
                              <div class="add_field_button"><i class="fa fa-plus"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Package Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') {{ $message }} @enderror
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
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Package</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.package.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div> -->
                </form>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
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
                $(wrapper).append('<div class="form-row"> <div class="form-group col-md-5"> <input class="form-control" type="text" name="duration[]" placeholder="Duration in day(s)"/> </div> <div class="form-group col-md-5"> <input type="text" class="form-control" name="price[]" placeholder="Price"/> </div> <div class="form-group col-md-2"> <div class="remove_field"><i class="fa fa-minus"></i></div> </div></div>'); //add input box
            }
        });
        
        $(document).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).closest('.form-row').remove(); x--;
        })

        $("#btnSave").on("click",function(){
            $('#form1').submit();
        })
    });

</script>

@endpush