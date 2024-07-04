@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<script src="{{ asset('backend/js/jquery-3.2.1.min.js') }}"></script>
	<div class="fixed-row">
		<div class="app-title">
			<div class="active-wrap">
				<h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
				<div class="form-group form-group-prev">
					<button class="btn btn-primary" type="submit" id="field_button" name="field_button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Form</button>
					
					<a style="margin-top: -2px;" class="btn btn-secondary" href="{{ route('admin.customform.index') }}"><i class="fa fa-chevron-left"></i>Back</a>
					<a data-toggle="modal" class="btn btn-secondary preview-btn" data-target="#myModal{{$targetForm->id}}"><i class="fa fa-eye"></i>Preview</a>
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
    		      <input class="form-control" type="text" name="form_name" id="form_name" value="{{$targetForm->name}}" required>
    		    </div>

    		    <div class="col-md-6 form-group toogle-lg toggle-lg-cf">
    		    	<label class="control-label">Status</label>
    		    	<div class="toggle-button-cover">
    		    		<div class="button-cover">
    		    			<div class="button-togglr b2" id="button-11">
    		    				<input id="toggle-block" type="checkbox" name="status" class="checkbox" {{ $targetForm->status == 1 ? 'checked' : '' }}>
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
    		<div class="tile  form-body">
    			<div class="form-group" id="category_type">
    			  <label class="control-label">Category</label>
    			  <input type="hidden" name="id" id="form_id" value="{{ $targetForm->id }}">
    			  <select name="category_type" class="form-control" style="width: 100%;">
    			    	<option value="-1">Select a value</option>
    			    @foreach($categorytypes as $categorytype)
    			        <?php 
    			        if($targetForm->category_id == $categorytype->id)
    			        { ?>
    			        <option value="{{$categorytype->id}}" selected>{{$categorytype->name}}</option>
    			        <?php 
    			        }else{
    			        ?>
    			        <option value="{{$categorytype->id}}">{{$categorytype->name}}</option>
    			        <?php 
    			        }
    			        ?>
    			    @endforeach
    			  </select>
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
<?php 
	$field_values = $form_fields;
	$form_id = $targetForm->id;
	$form_name = $targetForm->name;
?>
@include('admin.categoryforms.preview',compact('field_values','form_id','form_name'))
@endsection
@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
<script type="text/javascript">
var category_id= <?php echo $targetForm->category_id; ?>;
var form_fields = <?php echo json_encode($form_fields); ?>;
var checkbox_type = "checkbox_group";
var selectbox_type = "selectbox_group";
var radiobutton_type = "radio_group";
var ratefield_type = "rate_field_group";
var textbox_type = "text";
var textarea_type = "textarea";
var categoryHTML = '';
var total_edit_fields = form_fields.length;
createFormFields(form_fields);

function createFormFields(form_fields)
{
	var counter_textbox = 50;
	var counter_textarea = 50;
	var counter_check = 50;
	var counter_select = 50;
	var counter_radio = 50;
	var counter_rate = 50;
	for(var key in form_fields)
	{
		if(form_fields[key].type==checkbox_type)
		{
			categoryHTML = '';
			categoryHTML += '<div class="fieldbox check_box" id="textbox-checkbox">';
			categoryHTML += '<div class="row">';
			categoryHTML+=    '<div class="col-md-9">';
			categoryHTML+=      '<div><span id="checkspan'+counter_check+'">'+form_fields[key].label+'</span></div>';
			categoryHTML+=    '</div>';
			categoryHTML +=   '<div class="col-md-3 align-right">'
			categoryHTML+=      '<div class="btn-element-wrap"><a class="symbol-btn close-btn" href="#" title="Remove Element"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;</a><a class="symbol-btn edit-btn" id="edit-btn-check'+counter_check+'" data-id='+counter_check+' href="javascript:void(0);" title="Edit Element"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a></div>';
			categoryHTML+=    '</div>';
			categoryHTML+=  '</div>';
			categoryHTML+= '<div class="row toggle-field" id="toggle-field-check'+counter_check+'">';
			categoryHTML+=    '<div class="">';
			categoryHTML+=      '<div class="container">';
			categoryHTML+=        '<div class="row form-body">';
			var required_value = (form_fields[key].required == 1)? "checked":"";
			categoryHTML+=		'<div class="col-4"><label class="control-label">Label</label><input type="text" name="checkbox_group_label" placeholder="Checkbox Group Label" id="checklabel'+counter_check+'" data-id="'+counter_check+'" value="'+form_fields[key].label+'"></div><div class="col-4"><label class="control-label">Required</label><br><input type="checkbox" name="checkbox_group_required" '+required_value+'></div><div class="col-4"><label class="control-label">Order</label><input type="text" name="checkbox_group_order" placeholder="Checkbox Group Order" value="'+form_fields[key].order+'"></div>';
			categoryHTML+=			'</div>';
			categoryHTML+=		'</div>';

			var i=1;
			for (var checkbox_value_key in form_fields[key].values)
			{
				if(i>1)
				{
					var checkbox_values = form_fields[key].values[checkbox_value_key];
					var checked_condtn = (checkbox_values.check==1)?"checked":"";
					categoryHTML+='<div class="row option-row"><div class="col-1 frm-chkbx"><input type="checkbox" name="option_check[]" '+checked_condtn+' ></div><div class="col-5"><input type="text" placeholder="Option Label" name="option_label[]" value="'+checkbox_values.label+'"/></div><div class="col-5"><input type="text" placeholder="Option Value" name="option_value[]" value="'+checkbox_values.value+'"/></div><div class="col-1 pl-0"><a href="#" class="remove_field"><i class="fa fa-minus"></i></a></div></div>';
				}else{
					var checkbox_values = form_fields[key].values[checkbox_value_key];
					var checked_condtn = (checkbox_values.check==1)?"checked":"";
					categoryHTML+='<div class="col-12 frm-options form-body"><label class="control-label">Options</label></div>';
					categoryHTML+=      '<div class="container">';
					categoryHTML+=        '<div class="check_wrapper'+counter_check+'">';
					categoryHTML+='<div class="row option-row"><div class="col-1 frm-chkbx"></div><div class="col-5"><label class="control-label">Option Label</label></div><div class="col-5"><label class="control-label">Option Value</label></div><div class="col-1 pl-0"></div></div>';
					categoryHTML+='<div class="row option-row"><div class="col-1 frm-chkbx"><input type="checkbox" name="option_check[]"'+checked_condtn+'></div><div class="col-5"><input type="text" placeholder="Option Label" name="option_label[]" value="'+checkbox_values.label+'"/></div><div class="col-5"><input type="text" placeholder="Option Value" name="option_value[]" value="'+checkbox_values.value+'"/></div><div class="col-1 pl-0"><button class="check_box_bt check_add_button'+counter_check+'" data-id='+counter_check+'><i class="fa fa-plus"></i></button></div></div>';
				}

				i++;
				
			}
			categoryHTML+=    		'</div>';
			categoryHTML+=  	'</div>';
			categoryHTML+=    '</div>';
			categoryHTML+=  '</div>';
			categoryHTML+="</div>";
			var check_add_button      = $(".check_add_button"+counter_check); //Add button ID
				var check_wrapper         = $(".check_wrapper"+counter_check); //Fields wrapper
				var cbHtml = '';
				$(document).on("keyup","#checklabel"+counter_check,function(){
				var val = $(this).val();
				var data_id = $(this).data('id');
				console.log("testing"+data_id);
				$("#checkspan"+data_id).html(val);
				})
				$(document).on("click",".check_add_button"+counter_check, function(e){ //user click on remove text
					e.preventDefault(); 
					var data_id = $(this).data('id');
					
					cbHtml+='<div class="row option-row"><div class="col-1 frm-chkbx"><input type="checkbox" name="option_check[]"></div><div class="col-5"><input type="text" placeholder="Option Label" name="option_label[]"/></div><div class="col-5"><input type="text" placeholder="Option Value" name="option_value[]"/></div><div class="col-1 pl-0"><a href="#" class="remove_field"><i class="fa fa-minus"></i></a></div></div>';
					console.log(counter_check);
					$(".check_wrapper"+data_id).append(cbHtml); //add input box
					cbHtml = '';
				})

				$(document).on("click",".remove_field", function(e){ //user click on remove text
					e.preventDefault(); $(this).parents('.option-row').remove();
				})
				$(document).on("click","#edit-btn-check"+counter_check, function(e){
				var data_counter_id = $(this).data('id');
				$('#toggle-field-check'+data_counter_id).toggleClass("open-form");
					e.preventDefault();
				});
				$(document).on("click",".close-btn", function(e){ //user click on remove text
					e.preventDefault(); $(this).parents('.fieldbox').remove();
				})
				counter_check++;
			//$("#checkbox-populate").append(categoryHTML);
			$("#category-custom-form").append(categoryHTML);

		}else if(form_fields[key].type==selectbox_type)
		{

			categoryHTML = '';
			categoryHTML += '<div class="fieldbox select_box" id="textbox-selectbox">';
			categoryHTML += '<div class="row">';
			categoryHTML+=    '<div class="col-md-9">';
			categoryHTML+=      '<div><span id="selectspan'+counter_select+'">'+form_fields[key].label+'</span></div>';
			categoryHTML+=    '</div>';
			categoryHTML +=   '<div class="col-md-3 align-right">'
			categoryHTML+=      '<div class="btn-element-wrap"><a class="symbol-btn close-btn" href="#" title="Remove Element"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;</a><a class="symbol-btn edit-btn" id="edit-btn-select'+counter_select+'" data-id='+counter_select+' href="javascript:void(0);" title="Edit Element"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a></div>';
			categoryHTML+=    '</div>';
			categoryHTML+=  '</div>';
			categoryHTML+= '<div class="row toggle-field" id="toggle-field-select'+counter_select+'">';
			var required_value = (form_fields[key].required == 1)? "checked":"";
			categoryHTML+=    '<div class="">';
			categoryHTML+=      '<div class="container">';
			categoryHTML+=        '<div class="row form-body">';
			categoryHTML+=			'<div class="col-4"><label class="control-label">Label</label><input type="text" name="select_group_label" id="selectlabel'+counter_select+'" data-id="'+counter_select+'" placeholder="Selectbox Group Label" value="'+form_fields[key].label+'"></div><div class="col-4"><label class="control-label">Required</label><br><input type="checkbox" name="select_group_required" '+required_value+'></div><div class="col-4"><label class="control-label">Order</label><input type="text" name="select_group_order" placeholder="Selectbox Group Order" value="'+form_fields[key].order+'"></div>';
			categoryHTML+=			'</div>';
			categoryHTML+=		'</div>';
			categoryHTML+=      '<input type="hidden" name="radio_counter" value="'+form_fields[key].order+'">';

			var i=1;
			for (var selectbox_value_key in form_fields[key].values)
			{
				if(i>1)
				{
					var selectbox_values = form_fields[key].values[selectbox_value_key];
					var checked_condtn = (selectbox_values.check==1)?"checked":"";
					categoryHTML+='<div class="row option-row"><div class="col-1 frm-chkbx"><input type="radio" name="option_check'+form_fields[key].order+'" id="option_check" '+checked_condtn+'></div><div class="col-5"><input type="text" placeholder="Option Label" name="option_label[]" value="'+selectbox_values.label+'"/></div><div class="col-5"><input type="text" placeholder="Option Value" name="option_value[]" value="'+selectbox_values.value+'"/></div><div class="col-1 pl-0"><a href="#" class="remove_field"><i class="fa fa-minus"></i></a></div></div>';
				}else{
					var selectbox_values = form_fields[key].values[selectbox_value_key];
					var checked_condtn = (selectbox_values.check==1)?"checked":"";
					categoryHTML+='<div class="col-12 frm-options form-body"><label class="control-label">Options</label></div>';
					categoryHTML+=   '<div class="container">';
					categoryHTML+=	    '<div class="select_wrapper'+counter_select+'">'
					categoryHTML+=			'<div class="row option-row"><div class="col-1 frm-chkbx"></div><div class="col-5"><label class="control-label">Option Label</label></div><div class="col-5"><label class="control-label">Option Value</label></div><div class="col-1 pl-0"></div></div>';
					categoryHTML+=			'<div class="row option-row"><div class="col-1 frm-chkbx"><input type="radio" name="option_check'+form_fields[key].order+'" id="option_check" '+checked_condtn+'></div><div class="col-5"><input type="text" placeholder="Option Label" name="option_label[]" value="'+selectbox_values.label+'"/></div><div class="col-5"><input type="text" placeholder="Option Value" name="option_value[]" value="'+selectbox_values.value+'"/></div><div class="col-1 pl-0"><button class="select_box_bt select_add_button'+counter_select+'" data-id='+counter_select+'><i class="fa fa-plus"></i></button></div></div>';
				}
				
				i++;
				
			}
			categoryHTML+=    		'</div>';
			categoryHTML+=  	'</div>';
			categoryHTML+=    '</div>';
			categoryHTML+=  '</div>';
			categoryHTML+="</div>";
			var select_add_button      = $(".select_add_button"+counter_select); //Add button ID
				var select_wrapper         = $(".select_wrapper"+counter_select); //Fields wrapper
				var cbHtml = '';
				$(document).on("keyup","#selectlabel"+counter_select,function(){
				var val = $(this).val();
				var data_id = $(this).data('id');
				console.log("testing"+data_id);
				$("#selectspan"+data_id).html(val);
				})
				$(document).on("click",".select_add_button"+counter_select, function(e){ //user click on remove text
					e.preventDefault(); 
					var data_id = $(this).data('id');
					
					cbHtml+='<div class="row option-row"><div class="col-1 frm-chkbx"><input type="radio" name="option_check'+form_fields[key].order+'" id="option_check"></div><div class="col-5"><input type="text" placeholder="Option Label" name="option_label[]"/></div><div class="col-5"><input type="text" placeholder="Option Value" name="option_value[]"/></div><div class="col-1 pl-0"><a href="#" class="remove_field"><i class="fa fa-minus"></i></a></div></div>';
					console.log(counter_select);
					$(".select_wrapper"+data_id).append(cbHtml); //add input box
					cbHtml = '';
				})

				$(document).on("click",".remove_field", function(e){ //user click on remove text
					e.preventDefault(); $(this).parents('.option-row').remove();
				})
				$(document).on("click","#edit-btn-select"+counter_select, function(e){
				var data_counter_id = $(this).data('id');
				$("#toggle-field-select"+data_counter_id).toggleClass("open-form");
					e.preventDefault();
				});
				$(document).on("click",".close-btn", function(e){ //user click on remove text
					e.preventDefault(); $(this).parents('.fieldbox').remove();
				})
				counter_select++;
			//$("#selectbox-populate").append(categoryHTML);
			$("#category-custom-form").append(categoryHTML);
		}else if(form_fields[key].type==radiobutton_type)
		{

			categoryHTML = '';
			categoryHTML += '<div class="fieldbox radio_group_box" id="textbox-radio">';
			categoryHTML += '<div class="row">';
			categoryHTML+=    '<div class="col-md-9">';
			categoryHTML+=      '<div><span id="radiospan'+counter_radio+'">'+form_fields[key].label+'</span></div>';
			categoryHTML+=    '</div>';
			categoryHTML +=   '<div class="col-md-3 align-right">'
			categoryHTML+=      '<div class="btn-element-wrap"><a class="symbol-btn close-btn" href="#" title="Remove Element"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;</a><a class="symbol-btn edit-btn" id="edit-btn-radio'+counter_radio+'" data-id='+counter_radio+' href="javascript:void(0);" title="Edit Element"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a></div>';
			categoryHTML+=    '</div>';
			categoryHTML+=  '</div>';
			categoryHTML+= '<div class="row toggle-field" id="toggle-field-radio'+counter_radio+'">';
			var required_value = (form_fields[key].required == 1)? "checked":"";
			categoryHTML+=    '<div class="">';
			categoryHTML+=      '<div class="container">';
			categoryHTML+=        '<div class="row form-body">';
			categoryHTML+=			'<div class="col-4"><label class="control-label">Label</label><input type="text" name="radio_group_label" id="radiolabel'+counter_radio+'" data-id="'+counter_radio+'" placeholder="Radio Group Label" value="'+form_fields[key].label+'"></div><div class="col-4"><label class="control-label">Required</label><br><input type="checkbox" name="radio_group_required" '+required_value+'></div><div class="col-4"><label class="control-label">Order</label><input type="text" name="radio_group_order" placeholder="Radio Group Order" value="'+form_fields[key].order+'"></div>';
			categoryHTML+=			'</div>';
			categoryHTML+=		'</div>';
			categoryHTML+=      '<input type="hidden" name="radio_counter" value="'+form_fields[key].order+'">';

			var i=1;
			for (var radio_value_key in form_fields[key].values)
			{
				if(i>1)
				{
					var radio_values = form_fields[key].values[radio_value_key];
					var checked_condtn = (radio_values.check==1)?"checked":"";
					categoryHTML+='<div class="row option-row"><div class="col-1 frm-chkbx"><input type="radio" name="option_check'+form_fields[key].order+'" '+checked_condtn+'></div><div class="col-5"><input type="text" placeholder="Option Label" name="option_label[]" value="'+radio_values.label+'"/></div><div class="col-5"><input type="text" placeholder="Option Value" name="option_value[]" value="'+radio_values.value+'"/></div><div class="col-1 pl-0"><a href="#" class="remove_field"><i class="fa fa-minus"></i></a></div></div>';
				}else{
					var radio_values = form_fields[key].values[radio_value_key];
					var checked_condtn = (radio_values.check==1)?"checked":"";
					categoryHTML+='<div class="col-12 frm-options form-body"><label class="control-label">Options</label></div>';
					categoryHTML+=   '<div class="container">';
					categoryHTML+=	    '<div class="radio_wrapper'+counter_radio+'">'
					categoryHTML+='<div class="row option-row"><div class="col-1 frm-chkbx"></div><div class="col-5"><label class="control-label">Option Label</label></div><div class="col-5"><label class="control-label">Option Value</label></div><div class="col-1 pl-0"></div></div>';
					categoryHTML+='<div class="row option-row"><div class="col-1 frm-chkbx"><input type="radio" name="option_check'+form_fields[key].order+'" '+checked_condtn+'></div><div class="col-5"><input type="text" placeholder="Option Label" name="option_label[]" value="'+radio_values.label+'"/></div><div class="col-5"><input type="text" placeholder="Option Value" name="option_value[]" value="'+radio_values.value+'"/></div><div class="col-1 pl-0"><button class="radio_bt radio_add_button'+counter_radio+'" data-id='+counter_radio+'><i class="fa fa-plus"></i></button></div></div>';
				}
				
				i++;
				
			}
			categoryHTML+=    		'</div>';
			categoryHTML+=  	'</div>';
			categoryHTML+=    '</div>';
			categoryHTML+=  '</div>';
			categoryHTML+="</div>";
			var radio_add_button      = $(".radio_add_button"+counter_radio); //Add button ID
				var radio_wrapper         = $(".radio_wrapper"+counter_radio); //Fields wrapper
				var cbHtml = '';

				$(document).on("keyup","#radiolabel"+counter_radio,function(){
				var val = $(this).val();
				var data_id = $(this).data('id');
				console.log("testing"+data_id);
				$("#radiospan"+data_id).html(val);
				})
				$(document).on("click",".radio_add_button"+counter_radio, function(e){ //user click on remove text
					e.preventDefault(); 
					var data_id = $(this).data('id');
					
					cbHtml+='<div class="row option-row"><div class="col-1 frm-chkbx"><input type="radio" name="option_check'+form_fields[key].order+'"></div><div class="col-5"><input type="text" placeholder="Option Label" name="option_label[]"/></div><div class="col-5"><input type="text" placeholder="Option Value" name="option_value[]"/></div><div class="col-1 pl-0"><a href="#" class="remove_field"><i class="fa fa-minus"></i></a></div></div>';
					console.log(counter_radio);
					$(".radio_wrapper"+data_id).append(cbHtml); //add input box
					cbHtml = '';
				})

				$(document).on("click",".remove_field", function(e){ //user click on remove text
					e.preventDefault(); $(this).parents('.option-row').remove();
				})
				$(document).on("click","#edit-btn-radio"+counter_radio, function(e){
				var data_counter_id = $(this).data('id');
				$("#toggle-field-radio"+data_counter_id).toggleClass("open-form");
					e.preventDefault();
				});
				$(document).on("click",".close-btn", function(e){ //user click on remove text
					e.preventDefault(); $(this).parents('.fieldbox').remove();
				})
				counter_radio++;
			//$("#radiogroup-populate").append(categoryHTML);
			$("#category-custom-form").append(categoryHTML);
		}else if(form_fields[key].type==ratefield_type)
		{

			categoryHTML = '';
			categoryHTML += '<div class="fieldbox rate_group_box" id="textbox-rate">';
			categoryHTML += '<div class="row">';
			categoryHTML+=    '<div class="col-md-9">';
			categoryHTML+=      '<div><span id="ratespan'+counter_rate+'">'+form_fields[key].label+'</span></div>';
			categoryHTML+=    '</div>';
			categoryHTML +=   '<div class="col-md-3 align-right">'
			categoryHTML+=      '<div class="btn-element-wrap"><a class="symbol-btn close-btn" href="#" title="Remove Element"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;</a><a class="symbol-btn edit-btn" id="edit-btn-rate'+counter_rate+'" data-id='+counter_rate+' href="javascript:void(0);" title="Edit Element"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a></div>';
			categoryHTML+=    '</div>';
			categoryHTML+=  '</div>';
			categoryHTML+= '<div class="row toggle-field" id="toggle-field-rate'+counter_rate+'">';
			var required_value = (form_fields[key].required == 1)? "checked":"";
			categoryHTML+=    '<div class="">';
			categoryHTML+=      '<div class="container">';
			categoryHTML+=        '<div class="row form-body">';
			categoryHTML+=			'<div class="col-8"><label class="control-label">Label</label><input type="text" name="rate_group_label" id="ratelabel'+counter_rate+'" data-id="'+counter_rate+'" placeholder="Rate Group Label" value="'+form_fields[key].label+'"></div><div class="col-4"><label class="control-label">Required</label><br><input type="checkbox" name="rate_group_required" '+required_value+'></div><div class="col-4"><label class="control-label">Order</label><input type="text" name="rate_group_order" placeholder="Rate Group Order" value="'+form_fields[key].order+'"></div>';
			categoryHTML+=			'</div>';
			categoryHTML+=		'</div>';

			var i=1;
			for (var rate_value_key in form_fields[key].values)
			{
				if(i>1)
				{
					var rate_values = form_fields[key].values[rate_value_key];
					categoryHTML+='<div class="row option-row"><div class="col-11"><input type="text" placeholder="Price Label" name="price_label[]" value="'+rate_values.label+'"/></div><div class="col-1 pl-0"><a href="#" class="remove_field"><i class="fa fa-minus"></i></a></div></div>';
				}else{
					var rate_values = form_fields[key].values[rate_value_key];
					categoryHTML+='<div class="col-12 frm-options form-body"><label class="control-label">Options</label></div>';
					categoryHTML+=   '<div class="container">';
					categoryHTML+=	    '<div class="rate_wrapper'+counter_rate+'">'
					categoryHTML+='<div class="row option-row"><div class="col-11"><input type="text" placeholder="Price Label" name="price_label[]" value="'+rate_values.label+'"/></div><div class="col-1 pl-0"><button class="rate_bt rate_add_button'+counter_rate+'" data-id='+counter_rate+'><i class="fa fa-plus"></i></button></div></div>';
				}
				
				i++;
				
			}
			categoryHTML+=    		'</div>';
			categoryHTML+=  	'</div>';
			categoryHTML+=    '</div>';
			categoryHTML+=  '</div>';
			categoryHTML+="</div>";
			var rate_add_button      = $(".rate_add_button"+counter_rate); //Add button ID
				var rate_wrapper         = $(".rate_wrapper"+counter_rate); //Fields wrapper
				var cbHtml = '';

				$(document).on("keyup","#ratelabel"+counter_rate,function(){
				var val = $(this).val();
				var data_id = $(this).data('id');
				console.log("testing"+data_id);
				$("#ratespan"+data_id).html(val);
				})

				$(document).on("click",".rate_add_button"+counter_rate, function(e){ //user click on remove text
					e.preventDefault(); 
					var data_id = $(this).data('id');
					
					cbHtml+='<div class="row option-row"><div class="col-11"><input type="text" placeholder="Price Label" name="price_label[]"/></div><div class="col-1 pl-0"><a href="#" class="remove_field"><i class="fa fa-minus"></i></a></div></div>';
					console.log(counter_rate);
					$(".rate_wrapper"+data_id).append(cbHtml); //add input box
					cbHtml = '';
				})

				$(document).on("click",".remove_field", function(e){ //user click on remove text
					e.preventDefault(); $(this).parents('.option-row').remove();
				})

				$(document).on("click","#edit-btn-rate"+counter_rate, function(e){
				var data_counter_id = $(this).data('id');
				$("#toggle-field-rate"+data_counter_id).toggleClass("open-form");
					e.preventDefault();
				});

				$(document).on("click",".close-btn", function(e){ //user click on remove text
					e.preventDefault(); $(this).parents('.fieldbox').remove();
				})

				counter_rate++;
			//$("#ratefield-populate").append(categoryHTML);
			$("#category-custom-form").append(categoryHTML);
		}else if(form_fields[key].type==textbox_type)
		{
			categoryHTML = '';
			categoryHTML += '<div class="fieldbox textbox" id="textbox-textbox">';
			categoryHTML += '<div class="row">';
			categoryHTML+=    '<div class="col-md-9">';
			categoryHTML+=      '<div><span id="textboxspan'+counter_textbox+'">'+form_fields[key].label+'</span></div>';
			categoryHTML+=    '</div>'
			categoryHTML +=   '<div class="col-md-3 align-right">';
			categoryHTML+=      '<div class="btn-element-wrap"><a class="symbol-btn close-btn" href="#" title="Remove Element"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;</a><a class="symbol-btn edit-btn" id="edit-btn-textfield'+counter_textbox+'" data-id='+counter_textbox+' href="javascript:void(0);" title="Edit Element"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a></div>';
			categoryHTML+=    '</div>';
			categoryHTML+=  '</div>';
			categoryHTML+= '<div class="row toggle-field" id="toggle-field-textbox'+counter_textbox+'">';
			var required_value = (form_fields[key].required == 1)? "checked":"";
			categoryHTML+=    '<div class="col-md-12 form-body row">';
			categoryHTML+=      '<div class="col-4"><label class="control-label">Label</label><input type="text" id="textboxlabel'+counter_textbox+'" data-id="'+counter_textbox+'" placeholder="Enter textbox label" name="textbox_label[]" value="'+form_fields[key].label+'"></div><div class="col-4"><label class="control-label">Required</label><br><input type="checkbox" name="textbox_required" '+required_value+'></div><div class="col-4"><label class="control-label">Order</label><input type="text" name="textbox_order[]" value="'+form_fields[key].order+'" placeholder="Enter textbox order"></div>';
			categoryHTML+=    '</div>';
			categoryHTML+= '</div>';

			$(document).on("click",".close-btn", function(e){ //user click on remove text
				e.preventDefault(); $(this).parents('.fieldbox').remove();
			})
			$(document).on("keyup","#textboxlabel"+counter_textbox,function(){
				var val = $(this).val();
				var data_id = $(this).data('id');
				console.log("testing"+data_id);
				$("#textboxspan"+data_id).html(val);
			})
			$(document).on("click","#edit-btn-textfield"+counter_textbox, function(e){
				var data_counter_id = $(this).data('id');
				$('#toggle-field-textbox'+data_counter_id).toggleClass("open-form");
					e.preventDefault();
			});

			counter_textbox++;
			//$("#textfield-populate").append(categoryHTML);
			$("#category-custom-form").append(categoryHTML);
		}else if(form_fields[key].type==textarea_type)
		{

			categoryHTML = '';
			categoryHTML += '<div class="fieldbox textarea" id="textbox-textarea">';
			categoryHTML += '<div class="row">';
			categoryHTML+=    '<div class="col-md-9">';
			categoryHTML+=      '<div><span id="textareaspan'+counter_textarea+'">'+form_fields[key].label+'</span></div>';
			categoryHTML+=    '</div>'
			categoryHTML +=   '<div class="col-md-3 align-right">';
			categoryHTML+=      '<div class="btn-element-wrap"><a class="symbol-btn close-btn" href="#" title="Remove Element"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;</a><a class="symbol-btn edit-btn" id="edit-btn-textarea'+counter_textarea+'" data-id='+counter_textarea+' href="javascript:void(0);" title="Edit Element"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a></div>';
			categoryHTML+=    '</div>';
			categoryHTML+=  '</div>';
			categoryHTML+= '<div class="row toggle-field" id="toggle-field-textarea'+counter_textarea+'">';
			var required_value = (form_fields[key].required == 1)? "checked":"";
			categoryHTML+=    '<div class="col-md-12 form-body row">';
			categoryHTML+=      '<div class="col-4"><label class="control-label">Label</label><input type="text" id="texarealabel'+counter_textarea+'" data-id="'+counter_textarea+'" placeholder="Enter textbox label" name="textarea_label[]" value="'+form_fields[key].label+'"></div><div class="col-4"><label class="control-label">Required</label><br><input type="checkbox" name="textarea_required" '+required_value+'></div><div class="col-4"><label class="control-label">Order</label><input type="text" name="textarea_order[]" value="'+form_fields[key].order+'" placeholder="Enter textarea order"></div>';
			categoryHTML+=    '</div>';
			categoryHTML+= '</div>';

			$(document).on("click",".close-btn", function(e){ //user click on remove text
				e.preventDefault(); $(this).parents('.fieldbox').remove();
			})
			$(document).on("keyup","#texarealabel"+counter_textarea,function(){
				var val = $(this).val();
				var data_id = $(this).data('id');
				console.log("testing"+data_id);
				$("#textareaspan"+data_id).html(val);
			})
			$(document).on("click","#edit-btn-textarea"+counter_textarea, function(e){
				var data_counter_id = $(this).data('id');
				$('#toggle-field-textarea'+data_counter_id).toggleClass("open-form");
					e.preventDefault();
			});

			counter_textarea++;
			//$("#textarea-populate").append(categoryHTML);
			$("#category-custom-form").append(categoryHTML);
		}
	}
}

</script>
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

	    // $('.check_box').each(function() {
	    //     option_check_array=[];
	    //     option_label_array=[];
	    //     option_value_array=[];
	    //     option_array=[];
	    //        //get values
	    //        checkbox_group_order = $(this).find('input[name="checkbox_group_order"]').val();
	    //        checkbox_group_label = $(this).find('input[name="checkbox_group_label"]').val();
	    //        $(this).find('input[name="option_check[]"]').each(function(){
	    //                                   var checked = (this.checked ? 1 : 0);
	    //                                   option_check_array.push(checked);
	    //                               });
	    //        $(this).find('input[name="option_label[]"]').each(function() { 
	    //             option_label_array.push($(this).val()); 
	    //             });
	    //        $(this).find('input[name="option_value[]"]').each(function() { 
	    //             option_value_array.push($(this).val()); 
	    //             });
	    //        for(var i=0; i<option_label_array.length; i++)
	    //        {
	    //            var label = option_label_array[i];
	    //            var value = option_value_array[i];
	    //            var check = (option_check_array[i])?option_check_array[i]:0;
	    //            var obj = {label:label, value:value, check:check};
	    //            option_array.push(obj);
	    //        }
	    //        var option_obj = {type:type_checkbox,order:checkbox_group_order,label:checkbox_group_label,values:option_array};
	           
	    //        field_array.push(option_obj);
	        
	    //    });
	    // $('.select_box').each(function() {
	    // 	option_check_array=[];
	    //     option_label_array=[];
	    //     option_value_array=[];
	    //     option_array=[];
	    //        //get values
	    //        selectbox_group_order = $(this).find('input[name="select_group_order"]').val();
	    //        selectbox_group_label = $(this).find('input[name="select_group_label"]').val();
	    //        $(this).find('input[name="option_check[]"]').each(function(){
     //                  var checked = (this.checked ? 1 : 0);
     //                  option_check_array.push(checked);
     //              });
	    //        $(this).find('input[name="option_label[]"]').each(function() { 
	    //             option_label_array.push($(this).val()); 
	    //             });
	    //        $(this).find('input[name="option_value[]"]').each(function() { 
	    //             option_value_array.push($(this).val()); 
	    //             });
	    //        for(var i=0; i<option_label_array.length; i++)
	    //        {
	    //            var label = option_label_array[i];
	    //            var value = option_value_array[i];
	    //            var check = (option_check_array[i])?option_check_array[i]:0;
	    //            var obj = {label:label, value:value, check:check};
	    //            option_array.push(obj);
	    //        }
	    //        var option_obj = {type:type_selectbox,order:selectbox_group_order,label:selectbox_group_label,values:option_array};
	           
	    //        field_array.push(option_obj);
	        
	    //    });
	    // $('.radio_group_box').each(function() {
	    // 	option_check_array=[];
	    //     option_label_array=[];
	    //     option_value_array=[];
	    //     option_array=[];
	    //        //get values
	    //        radio_group_order = $(this).find('input[name="radio_group_order"]').val();
	    //        radio_group_label = $(this).find('input[name="radio_group_label"]').val();
	    //        $(this).find('input[name="option_check[]"]').each(function(){
     //                  var checked = (this.checked ? 1 : 0);
     //                  option_check_array.push(checked);
     //              });
	    //        $(this).find('input[name="option_label[]"]').each(function() { 
	    //             option_label_array.push($(this).val()); 
	    //             });
	    //        $(this).find('input[name="option_value[]"]').each(function() { 
	    //             option_value_array.push($(this).val()); 
	    //             });
	    //        for(var i=0; i<option_label_array.length; i++)
	    //        {
	    //            var label = option_label_array[i];
	    //            var value = option_value_array[i];
	    //            var check = (option_check_array[i])?option_check_array[i]:0;
	    //            var obj = {label:label, value:value, check:check};
	    //            option_array.push(obj);
	    //        }
	    //        var option_obj = {type:type_radio,order:radio_group_order,label:radio_group_label,values:option_array};
	           
	    //        field_array.push(option_obj);
	        
	    //    });
	    // $('.rate_group_box').each(function() {
	    //     option_label_array=[];
	    //     option_array=[];
	    //        //get values
	    //        rate_group_order = $(this).find('input[name="rate_group_order"]').val();
	    //        rate_group_label = $(this).find('input[name="rate_group_label"]').val();

	    //        $(this).find('input[name="price_label[]"]').each(function() { 
	    //             option_label_array.push($(this).val()); 
	    //             });
	    //        for(var i=0; i<option_label_array.length; i++)
	    //        {
	    //            var label = option_label_array[i];
	    //            var obj = {label:label};
	    //            option_array.push(obj);
	    //        }
	    //        var option_obj = {type:type_rate,order:rate_group_order,label:rate_group_label,values:option_array};
	           
	    //        field_array.push(option_obj);
	        
	    //    });

	    // $('.textbox').each(function() {
	    //     textbox_order_array=[];
	    //     textbox_label_array=[];
	    //        //get values
	    //        $(this).find('input[name="textbox_order[]"]').each(function() { 
	    //             textbox_order_array.push($(this).val()); 
	    //             });
	    //        $(this).find('input[name="textbox_label[]"]').each(function() { 
	    //             textbox_label_array.push($(this).val()); 
	    //             });
	      
	    //        for(var i=0; i<textbox_label_array.length; i++)
	    //        {
	    //            var order = textbox_order_array[i];
	    //            var label = textbox_label_array[i];
	    //            var obj = {type:type_textbox,order:order,label:label};
	    //            field_array.push(obj);
	    //        }
	        
	    //    });

	    // $('.textarea').each(function() {
	    //     textarea_order_array=[];
	    //     textarea_label_array=[];
	    //        //get values
	    //        $(this).find('input[name="textarea_order[]"]').each(function() { 
	    //             textarea_order_array.push($(this).val()); 
	    //             });
	    //        $(this).find('input[name="textarea_label[]"]').each(function() { 
	    //             textarea_label_array.push($(this).val()); 
	    //             });
	           
	    //        for(var i=0; i<textarea_label_array.length; i++)
	    //        {
	    //            var order = textarea_order_array[i];
	    //            var label = textarea_label_array[i];
	    //            var obj = {type:type_textarea,order:order,label:label};
	    //            field_array.push(obj);
	    //        }
	        
	    //    });
	    
	    
	    console.log(field_array);
	    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	    var category_id = $("#category_type").find(":selected").val();
	    var form_name = $("#form_name").val();
	    var id = $("#form_id").val();
	    var status = 0;
	    if($('input[name="status"]').is(":checked"))
	    {
	      status = 1;
	    }else{
	      status = 0;
	    }
	    $.ajax({
	      type:'POST',
	      dataType:'JSON',
	      url:"{{route('admin.customform.update')}}",
	      data:{ _token: CSRF_TOKEN, field_array:field_array, category_type:category_id, form_name:form_name, status:status, id:id},
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
	        swal("Error!", error_message, "error");

	      }
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

	});
</script>
@endpush