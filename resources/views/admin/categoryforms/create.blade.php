@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
   <div class="fixed-row">
    <div class="app-title">
        <div class="active-wrap">
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" id="field_button" name="field_button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Form</button>
                &nbsp;&nbsp;&nbsp;
                <a class="btn btn-secondary" href="{{ route('admin.customform.index') }}"><i class="fa fa-chevron-left"></i>Back</a>
            </div>
        </div>
    </div>
    </div>
    @include('admin.partials.flash')
    <div class="alert alert-success" id="success-msg" style="display: none;">
        <span id="success-text"></span>
    </div>
    <div class="alert alert-danger" id="error-msg" style="display: none;">
        <span id="error-text"></span>
    </div>
    <div class="row section-mg row-md-body no-nav custom-form">
        <div class="col-md-8 order-2 order-md-1">
            <div class="tile">
                <div class="tile-body form-body row">
                    <div class="col-md-6 form-group">
                        <label class="control-label">Form Name <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control" type="text" name="form_name" id="form_name" required>
                    </div>
                    <div class="col-md-6 form-group toogle-lg toggle-lg-cf">
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
            </div>
            <div class="tile">
                <div class="form-group">
                <!--fieldbox single-->
                    <div id="category-custom-form">
                    </div>
                    <!-- <div id="checkbox-populate">
                        
                    </div>

                    <div id="selectbox-populate">
                        
                    </div>
                    
                    <div id="radiogroup-populate">
                        
                    </div>
                
                    <div id="ratefield-populate">
                        
                    </div>
                    
                    <div id="textfield-populate">
                        
                    </div>

                    <div id="textarea-populate">
                        
                    </div> -->
                
                </div>
            </div>
        </div>
        <div class="col-md-4 order-1 order-md-2">
            <div class="tile">
                <div class="custom-form-editor">
                    <div class="tile-body form-body">
                        <div class="form-group">
                            <label class="control-label">Category</label>
                            <select id="category_type" name="category_type" class="form-control" style="width: 100%;">
                                <option value="-1">Select a value</option>
                                @foreach($categorytypes as $categorytype)
                                <option value="{{$categorytype->id}}">{{$categorytype->name}}</option>
                                @endforeach
                            </select>
                        </div>
<!--
                      <div class="form-group">
                          <div id="textbox-populate">

                          </div>
                      </div>
-->
                    </div>  
                </div>
            </div>
            <div class="tile no-padding">
                <ul class="custom-form-inputs">
                    <li><button onclick="appendCheckBox()"><i class="fa fa-check-square-o" aria-hidden="true"></i>Checkbox </button></li>
                    <li><button onclick="appendSelectBox()"><i class="fa fa-tasks" aria-hidden="true"></i>Select Box </button></li>
                    <li><button onclick="appendRadioButton()"><i class="fa fa-circle" aria-hidden="true"></i> Radio Button </button></li>
                    <li><button onclick="appendRateFieldButton()"><i class="fa fa-line-chart" aria-hidden="true"></i> Rate Field </button></li>
                    <li><button onclick="appendTextBox()"><i class="fa fa-file-text" aria-hidden="true"></i>Textbox </button></li>
                    <li><button onclick="appendTextArea()"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> Textarea </button></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
<script src="{{ asset('backend/js/custom-category-form.js') }}"></script>
<script type="text/javascript">
$(document).on('click', "#field_button", function(){
    var checkbox_group_label;
    var checkbox_group_order;
    var checkbox_group_required;
    var selectbox_group_label;
    var selectbox_group_order;
    var selectbox_group_required;
    var radio_group_label;
    var radio_group_order;
    var radio_group_required;
    var rate_group_label;
    var rate_group_order;
    var rate_group_required;
    var type_checkbox = "checkbox_group";
    var type_selectbox = "selectbox_group";
    var type_radio = "radio_group";
    var type_rate = "rate_field_group"; 
    var type_textbox = "text"; 
    var type_textarea = "textarea"; 
    var field_array=new Array();
    var option_label_array=new Array();
    var option_check_array=new Array();
    var option_value_array=new Array();
    var option_array = new Array();
    var textbox_order_array=new Array();
    var textbox_label_array=new Array();
    var textbox_value_array=new Array();
    var textbox_array = new Array();
    var textbox_required;
    var textarea_order_array=new Array();
    var textarea_label_array=new Array();
    var textarea_value_array=new Array();
    var textarea_array = new Array();
    var textarea_required;

    $("#category-custom-form").children().each(function(index) {
        if($(this).hasClass('check_box')) {
            var obj = $(this);
            field_array.push(generateFormOutput(obj, 'check_field'));
            //console.log(obj.find('input[name="checkbox_group_label"]').val());
        } else if($(this).hasClass('select_box')) {
            var obj = $(this);
            field_array.push(generateFormOutput(obj, 'select_field'));
        } else if($(this).hasClass('radio_group_box')) {
            var obj = $(this);
            field_array.push(generateFormOutput(obj, 'radio_field'));
        } else if($(this).hasClass('rate_group_box')) {
            var obj = $(this);
            field_array.push(generateFormOutput(obj, 'rate_field'));
        } else if($(this).hasClass('textbox')) {
            var obj = $(this);
            field_array.push(generateFormOutput(obj, 'text_field'));
        } else if($(this).hasClass('textarea')) {
            var obj = $(this);
            field_array.push(generateFormOutput(obj, 'textarea_field'));
        }
    });
    /* $('.check_box').each(function() {
        option_check_array=[];
        option_label_array=[];
        option_value_array=[];
        option_array=[];
        //get values
        checkbox_group_label = $(this).find('input[name="checkbox_group_label"]').val();
        checkbox_group_order = $(this).find('input[name="checkbox_group_order"]').val();

        $(this).find('input[name="option_check[]"]').each(function(){
            var checked = (this.checked ? 1 : 0);
            option_check_array.push(checked);
        });
        
        $(this).find('input[name="option_label[]"]').each(function() { 
            option_label_array.push($(this).val());
        });
        $(this).find('input[name="option_value[]"]').each(function() { 
            option_value_array.push($(this).val());
        });
        for(var i=0; i<option_label_array.length; i++)
        {
            var label = option_label_array[i];
            var value = option_value_array[i];
            var check = option_check_array[i];
            var obj = {label:label, value:value, check:check};
            option_array.push(obj);
        }
        var option_obj = {type:type_checkbox,order:checkbox_group_order,label:checkbox_group_label,values:option_array};
        
        field_array.push(option_obj);
    });
    $('.select_box').each(function() {
        option_check_array=[];
        option_label_array=[];
        option_value_array=[];
        option_array=[];
        //get values
        selectbox_group_label = $(this).find('input[name="select_group_label"]').val();
        selectbox_group_order = $(this).find('input[name="select_group_order"]').val();
        $(this).find('input[name="option_check[]"]').each(function(){
                        var checked = (this.checked ? 1 : 0);
                        option_check_array.push(checked);
                    });
        $(this).find('input[name="option_label[]"]').each(function() { 
            option_label_array.push($(this).val()); 
            });
        $(this).find('input[name="option_value[]"]').each(function() { 
            option_value_array.push($(this).val()); 
            });
        for(var i=0; i<option_label_array.length; i++)
        {
            var label = option_label_array[i];
            var value = option_value_array[i];
            var check = (option_check_array[i])?option_check_array[i]:0;
            var obj = {label:label, value:value, check:check};
            option_array.push(obj);
        }
        var option_obj = {type:type_selectbox,order:selectbox_group_order,label:selectbox_group_label,values:option_array};
        
        field_array.push(option_obj);
    
    });
    $('.radio_group_box').each(function() {
        option_check_array=[];
        option_label_array=[];
        option_value_array=[];
        option_array=[];
        //get values
        radio_group_label = $(this).find('input[name="radio_group_label"]').val();
        radio_group_order = $(this).find('input[name="radio_group_order"]').val();
        $(this).find('input[name="option_check[]"]').each(function(){
            var checked = (this.checked ? 1 : 0);
            option_check_array.push(checked);
        });
        $(this).find('input[name="option_label[]"]').each(function() { 
            option_label_array.push($(this).val()); 
        });
        $(this).find('input[name="option_value[]"]').each(function() { 
            option_value_array.push($(this).val()); 
        });
        for(var i=0; i<option_label_array.length; i++)
        {
            var label = option_label_array[i];
            var value = option_value_array[i];
            var check = (option_check_array[i])?option_check_array[i]:0;
            var obj = {label:label, value:value, check:check};
            option_array.push(obj);
        }
        var option_obj = {type:type_radio,order:radio_group_order,label:radio_group_label,values:option_array};
        
        field_array.push(option_obj);
    });
    $('.rate_group_box').each(function() {
        option_label_array=[];
        option_array=[];
        //get values
        rate_group_label = $(this).find('input[name="rate_group_label"]').val();
        rate_group_order = $(this).find('input[name="rate_group_order"]').val();
        $(this).find('input[name="price_label[]"]').each(function() { 
            option_label_array.push($(this).val()); 
            });
        for(var i=0; i<option_label_array.length; i++)
        {
            var label = option_label_array[i];
            var obj = {label:label};
            option_array.push(obj);
        }
        var option_obj = {type:type_rate,order:rate_group_order,label:rate_group_label,values:option_array};
        
        field_array.push(option_obj);
    
    });

    $('.textbox').each(function() {
        textbox_order_array=[];
        textbox_label_array=[];
        textbox_name_array=[];
        //get values
        $(this).find('input[name="textbox_order[]"]').each(function() { 
            textbox_order_array.push($(this).val()); 
            });
        $(this).find('input[name="textbox_label[]"]').each(function() { 
            textbox_label_array.push($(this).val()); 
            });
        $(this).find('input[name="textbox_name[]"]').each(function() { 
            textbox_name_array.push($(this).val()); 
            });
        for(var i=0; i<textbox_label_array.length; i++)
        {
            var order = textbox_order_array[i];
            var label = textbox_label_array[i];
            var name = textbox_name_array[i];
            var obj = {type:type_textbox,order:order,label:label, name:name};
            field_array.push(obj);
        }
    });

    $('.textarea').each(function() {
        textarea_order_array=[];
        textarea_label_array=[];
        textarea_name_array=[];
        //get values
        $(this).find('input[name="textarea_order[]"]').each(function() { 
            textarea_order_array.push($(this).val()); 
            });
        $(this).find('input[name="textarea_label[]"]').each(function() { 
            textarea_label_array.push($(this).val()); 
            });
        $(this).find('input[name="textarea_name[]"]').each(function() { 
            textarea_name_array.push($(this).val()); 
            });
        for(var i=0; i<textarea_label_array.length; i++)
        {
            var order = textarea_order_array[i];
            var label = textarea_label_array[i];
            var name = textarea_name_array[i];
            var obj = {type:type_textarea,order:order,label:label, name:name};
            field_array.push(obj);
        }
    }); */

    // console.log(field_array);
    // return false;
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var category_id = $("#category_type").find(":selected").val();
    var form_name = $("#form_name").val();
    var status;
    if($('input[name="status"]').is(":checked"))
    {
      status = 1;
    }else{
      status = 0;
    }
    
    $.ajax({
        type:'POST',
        dataType:'json',
        url:"{{route('admin.customform.store')}}",
        data:{ _token: CSRF_TOKEN, field_array:field_array, category_type:category_id, form_name:form_name, status:status},
        success:function(response)
        {
            swal("Success!", response.message, "success");  
        },
        error: function(response)
        {
            var errors = response.responseJSON.errors;
            var error_message = '';
            $.each(errors, function(key, value){
                error_message += value;
            });
            console.log(response);
            swal("Error!", error_message, "error");
        }
    });
});

function generateFormOutput(obj, type){
    var type_checkbox = "checkbox_group";
    var type_selectbox = "selectbox_group";
    var type_radio = "radio_group";
    var type_rate = "rate_field_group"; 
    var type_textbox = "text"; 
    var type_textarea = "textarea";
    var field_array = new Array();
    if (type == 'text_field') {
        textbox_order_array=[];
        textbox_label_array=[];
        //get values
        obj.find('input[name="textbox_order[]"]').each(function() { 
            textbox_order_array.push($(this).val()); 
        });
        obj.find('input[name="textbox_label[]"]').each(function() { 
            textbox_label_array.push($(this).val()); 
        });
        textbox_required = (obj.find('input[name="textbox_required"]:checked').length > 0)? 1: 0;

        for(var i=0; i<textbox_label_array.length; i++)
        {
            var order = textbox_order_array[i];
            var label = textbox_label_array[i];
            var obj_elm = {type:type_textbox,order:order,label:label,required:textbox_required};
            return obj_elm;
        }
    } else if(type == 'textarea_field') {
        textarea_order_array=[];
        textarea_label_array=[];
        //get values
        obj.find('input[name="textarea_order[]"]').each(function() { 
            textarea_order_array.push($(this).val()); 
        });
        obj.find('input[name="textarea_label[]"]').each(function() { 
            textarea_label_array.push($(this).val()); 
        });
        textarea_required = (obj.find('input[name="textarea_required"]:checked').length > 0)? 1: 0;
        for(var i=0; i<textarea_label_array.length; i++)
        {
            var order = textarea_order_array[i];
            var label = textarea_label_array[i];
            var obj_elm = {type:type_textarea,order:order,label:label,required:textarea_required};
            return obj_elm;
        }
    } else if(type == 'check_field') {
        option_check_array=[];
        option_label_array=[];
        option_value_array=[];
        option_array=[];
        //get values
        checkbox_group_label = obj.find('input[name="checkbox_group_label"]').val();
        checkbox_group_order = obj.find('input[name="checkbox_group_order"]').val();
        checkbox_group_required = (obj.find('input[name="checkbox_group_required"]:checked').length > 0)? 1: 0;

        obj.find('input[name="option_check[]"]').each(function(){
            var checked = (this.checked ? 1 : 0);
            option_check_array.push(checked);
        });
        
        obj.find('input[name="option_label[]"]').each(function() { 
            option_label_array.push($(this).val());
        });
        obj.find('input[name="option_value[]"]').each(function() { 
            option_value_array.push($(this).val());
        });
        for(var i=0; i<option_label_array.length; i++)
        {
            var label = option_label_array[i];
            var value = option_value_array[i];
            var check = option_check_array[i];
            var obj = {label:label, value:value, check:check};
            option_array.push(obj);
        }
        var obj_elm = {type:type_checkbox,order:checkbox_group_order,label:checkbox_group_label,required:checkbox_group_required,values:option_array};
        
        return obj_elm;
    } else if(type == 'radio_field') {
        option_check_array=[];
        option_label_array=[];
        option_value_array=[];
        option_array=[];
        //get values
        radio_group_label = obj.find('input[name="radio_group_label"]').val();
        radio_group_order = obj.find('input[name="radio_group_order"]').val();
        radio_group_required = (obj.find('input[name="radio_group_required"]:checked').length > 0)? 1: 0;
        var radio_counter = obj.find('input[name="radio_counter"]').val();
        obj.find('input[name="option_check'+radio_counter+'"]').each(function(){
            var checked = (this.checked ? 1 : 0);
            option_check_array.push(checked);
        });
        obj.find('input[name="option_label[]"]').each(function() { 
            option_label_array.push($(this).val()); 
        });
        obj.find('input[name="option_value[]"]').each(function() { 
            option_value_array.push($(this).val()); 
        });
        for(var i=0; i<option_label_array.length; i++)
        {
            var label = option_label_array[i];
            var value = option_value_array[i];
            var check = (option_check_array[i])?option_check_array[i]:0;
            var obj = {label:label, value:value, check:check};
            option_array.push(obj);
        }
        var obj_elm = {type:type_radio,order:radio_group_order,label:radio_group_label,required:radio_group_required,values:option_array};
        
        return obj_elm;
    } else if(type == 'select_field') {
        option_check_array=[];
        option_label_array=[];
        option_value_array=[];
        option_array=[];
        //get values
        selectbox_group_label = obj.find('input[name="select_group_label"]').val();
        selectbox_group_order = obj.find('input[name="select_group_order"]').val();
        selectbox_group_required = obj.find('input[name="select_group_required"]').val();
        var radio_counter = obj.find('input[name="radio_counter"]').val();
        obj.find('input[name="option_check'+radio_counter+'"]').each(function(){
            var checked = (this.checked ? 1 : 0);
            option_check_array.push(checked);
        });
        obj.find('input[name="option_label[]"]').each(function() { 
            option_label_array.push($(this).val()); 
        });
        obj.find('input[name="option_value[]"]').each(function() { 
            option_value_array.push($(this).val()); 
        });
        for(var i=0; i<option_label_array.length; i++)
        {
            var label = option_label_array[i];
            var value = option_value_array[i];
            var check = (option_check_array[i])?option_check_array[i]:0;
            var obj = {label:label, value:value, check:check};
            option_array.push(obj);
        }
        var obj_elm = {type:type_selectbox,order:selectbox_group_order,label:selectbox_group_label,required:selectbox_group_required,values:option_array};
        
        return obj_elm;
    } else if(type == 'rate_field') {
        option_label_array=[];
        option_array=[];
        //get values
        rate_group_label = obj.find('input[name="rate_group_label"]').val();
        rate_group_order = obj.find('input[name="rate_group_order"]').val();
        rate_group_required = obj.find('input[name="rate_group_required"]').val();
        obj.find('input[name="price_label[]"]').each(function() { 
            option_label_array.push($(this).val()); 
        });
        for(var i=0; i<option_label_array.length; i++)
        {
            var label = option_label_array[i];
            var obj = {label:label};
            option_array.push(obj);
        }
        var obj_elm = {type:type_rate,order:rate_group_order,label:rate_group_label,required:rate_group_required,values:option_array};
        
        return obj_elm;
    }
}
</script>
@endpush