    
    var counter_check = 1;
    var counter_select = 1;
    var counter_radio = 1;
    var counter_rate = 1;
    var counter_textbox=1;
    var counter_textarea=1;
    var counter_field;
    if(typeof total_edit_fields === 'undefined')
    {
      counter_field = 0;
    }else{
      counter_field = total_edit_fields;
    }

    function appendTextBox()
    {
      counter_field++;
      var customizeHtml = ''
      customizeHtml += '<div class="fieldbox textbox" id="textbox-textbox">';
      customizeHtml += '<div class="row">';
      customizeHtml+=    '<div class="col-md-9">';
      customizeHtml+=      '<div><span id="textboxspan'+counter_textbox+'">Textbox</span></div>';
      customizeHtml+=    '</div>'
      customizeHtml +=   '<div class="col-md-3 align-right">';
      customizeHtml+=      '<div class="btn-element-wrap"><a class="symbol-btn close-btn" href="#" title="Remove Element"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;</a><a class="symbol-btn edit-btn" id="edit-btn-textfield'+counter_textbox+'" data-id='+counter_textbox+' href="javascript:void(0);" title="Edit Element"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a></div>';
      customizeHtml+=    '</div>';
      customizeHtml+=  '</div>';
      customizeHtml+= '<div class="row toggle-field" id="toggle-field-textbox'+counter_textbox+'">';
      customizeHtml+=    '<div class="col-md-12 form-body row">';
      customizeHtml+=      '<div class="col-4"><label class="control-label">Label</label><input type="text" id="textboxlabel'+counter_textbox+'" data-id="'+counter_textbox+'" placeholder="Enter textbox label" value="Textbox" name="textbox_label[]"></div><div class="col-4"><label class="control-label">Required</label><br><input type="checkbox" name="textbox_required"></div><div class="col-4"><label class="control-label">Order</label><input type="text" name="textbox_order[]" placeholder="Enter textbox order" value="'+counter_field+'"></div>';
      customizeHtml+=    '</div>';
      customizeHtml+= '</div>';

      $(document).on("click",".close-btn", function(e){ //user click on remove text
          e.preventDefault(); $(this).parents('.fieldbox').remove();
      })

      $(document).on("keyup","#textboxlabel"+counter_textbox,function(){
         var val = $(this).val();
         var data_id = $(this).data('id');
         //console.log("testing"+data_id);
         $("#textboxspan"+data_id).html(val);
      })

      $(document).on("click","#edit-btn-textfield"+counter_textbox, function(e){
       var data_counter_id = $(this).data('id');
        $('#toggle-field-textbox'+data_counter_id).toggleClass("open-form");
           e.preventDefault();
      });

      counter_textbox++;
      //$('#textfield-populate').append(customizeHtml);
      $('#category-custom-form').append(customizeHtml);
    }
    function appendTextArea()
    {
      counter_field++;
      var customizeHtml = ''

      customizeHtml += '<div class="fieldbox textarea" id="textbox-textarea">';
      customizeHtml += '<div class="row">';
      customizeHtml+=    '<div class="col-md-9">';
      customizeHtml+=      '<div><span id="textareaspan'+counter_textarea+'">Textarea</span></div>';
      customizeHtml+=    '</div>'
      customizeHtml +=   '<div class="col-md-3 align-right">';
      customizeHtml+=      '<div class="btn-element-wrap"><a class="symbol-btn close-btn" href="#" title="Remove Element"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;</a><a class="symbol-btn edit-btn" id="edit-btn-textarea'+counter_textarea+'" data-id='+counter_textarea+' href="javascript:void(0);" title="Edit Element"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a></div>';
      customizeHtml+=    '</div>';
      customizeHtml+=  '</div>';
      customizeHtml+= '<div class="row toggle-field" id="toggle-field-textarea'+counter_textarea+'">';
      customizeHtml+=    '<div class="col-md-12 form-body row">';
      customizeHtml+=      '<div class="col-4"><label class="control-label">Label</label><input type="text" id="texarealabel'+counter_textarea+'" data-id="'+counter_textarea+'" placeholder="Enter textarea label" value="Textarea" name="textarea_label[]"></div><div class="col-4"><label class="control-label">Required</label><br><input type="checkbox" name="textarea_required"></div><div class="col-4"><label class="control-label">Order</label><input type="text" placeholder="Enter textarea order" name="textarea_order[]" value="'+counter_field+'"></div>';
      customizeHtml+=    '</div>';
      customizeHtml+= '</div>';

      $(document).on("click",".close-btn", function(e){ //user click on remove text
          e.preventDefault(); $(this).parents('.fieldbox').remove();
      })

      $(document).on("keyup","#texarealabel"+counter_textarea,function(){
         var val = $(this).val();
         var data_id = $(this).data('id');
         //console.log("testing"+data_id);
         $("#textareaspan"+data_id).html(val);
      })

      $(document).on("click","#edit-btn-textarea"+counter_textarea, function(e){
       var data_counter_id = $(this).data('id');
        $('#toggle-field-textarea'+data_counter_id).toggleClass("open-form");
           e.preventDefault();
      });

      counter_textarea++;
      //$('#textarea-populate').append(customizeHtml);
      $('#category-custom-form').append(customizeHtml);
    }

    function appendCheckBox()
    {
       // var d = document.getElementById('textbox-populate');
       counter_field++;
       var customizeHtml = '';
       customizeHtml += '<div class="fieldbox check_box" id="textbox-checkbox">';
       customizeHtml += '<div class="row">';
       customizeHtml+=    '<div class="col-md-9">';
       customizeHtml+=      '<div><span id="checkspan'+counter_check+'">Checkbox</span></div>';
       customizeHtml+=    '</div>'
       customizeHtml +=   '<div class="col-md-3 align-right">'
       customizeHtml+=      '<div class="btn-element-wrap"><a class="symbol-btn close-btn" href="#" title="Remove Element"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;</a><a class="symbol-btn edit-btn" id="edit-btn-check'+counter_check+'" data-id='+counter_check+' href="javascript:void(0);" title="Edit Element"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a></div>';
       customizeHtml+=    '</div>';
       customizeHtml+=  '</div>';
       customizeHtml+= '<div class="row toggle-field" id="toggle-field-check'+counter_check+'">';
       customizeHtml+=    '<div class="">';
       customizeHtml+=      '<div class="container">';
       customizeHtml+=        '<div class="row form-body">';
       customizeHtml+=          '<div class="col-4"><label class="control-label">Label</label><input type="text" name="checkbox_group_label" id="checklabel'+counter_check+'" data-id="'+counter_check+'" placeholder="Checkbox Group Label" value="Checkbox"></div><div class="col-4"><label class="control-label">Required</label><br><input type="checkbox" name="checkbox_group_required"></div><div class="col-4"><label class="control-label">Order</label><input type="text" name="checkbox_group_order" placeholder="Checkbox Group Order" value="'+counter_field+'"></div>';
       customizeHtml+=        '</div>'
       customizeHtml+=       '</div>'
       customizeHtml+=      '<div class="col-12 frm-options form-body"><label class="control-label">Options</label></div>';
       customizeHtml+=      '<div class="container">';
       customizeHtml+=        '<div class="check_wrapper'+counter_check+'">';
       customizeHtml+=          '<div class="row option-row"><div class="col-1 frm-chkbx"></div><div class="col-5"><label class="control-label">Option Label</label></div><div class="col-5"><label class="control-label">Option Value</label></div><div class="col-1 pl-0"></div></div>';
       customizeHtml+=          '<div class="row option-row"><div class="col-1 frm-chkbx"><input type="checkbox" name="option_check[]"></div><div class="col-5"><input type="text" placeholder="Option Label" name="option_label[]" value="Option 1"></div><div class="col-5"><input type="text" placeholder="Option Value" name="option_value[]" value="option-1"></div><div class="col-1 pl-0"><button class="check_box_bt check_add_button'+counter_check+'" data-id='+counter_check+'><i class="fa fa-plus"></i></button></div></div>';
       customizeHtml+=        '</div>';
       customizeHtml+=       '</div>';
       customizeHtml+=    '</div>';
       customizeHtml+=  '</div>';
       var check_add_button      = $(".check_add_button"+counter_check); //Add button ID
        var check_wrapper         = $(".check_wrapper"+counter_check); //Fields wrapper

       var cbHtml = '';
       $(document).on("keyup","#checklabel"+counter_check,function(){
          var val = $(this).val();
          var data_id = $(this).data('id');
          //console.log("testing"+data_id);
          $("#checkspan"+data_id).html(val);
       })
       
       $(document).on("click",".check_add_button"+counter_check, function(e){ //user click on remove text
           e.preventDefault(); 
           var data_id = $(this).data('id');
           
           cbHtml+='<div class="row option-row"><div class="col-1 frm-chkbx"><input type="checkbox" name="option_check[]"></div><div class="col-md-5"><input type="text" placeholder="Option Label" name="option_label[]"/></div><div class="col-md-5"><input type="text" placeholder="Option Value" name="option_value[]"/></div><div class="col-md-1 pl-0"><a href="#" class="remove_field"><i class="fa fa-minus"></i></a></div></div>';
           console.log(counter_check);
            $(".check_wrapper"+data_id).append(cbHtml); //add input box
            cbHtml = '';
       })

       $(document).on("click",".remove_field", function(e){ //user click on remove text
           e.preventDefault(); $(this).parents('.option-row').remove();
       })

       $(document).on("click",".close-btn", function(e){ //user click on remove text
           e.preventDefault(); $(this).parents('.fieldbox').remove();
       })

       $(document).on("click","#edit-btn-check"+counter_check, function(e){
        var data_counter_id = $(this).data('id');
         $('#toggle-field-check'+data_counter_id).toggleClass("open-form");
            e.preventDefault();
       });

       counter_check++;
       //$('#checkbox-populate').append(customizeHtml);
       $('#category-custom-form').append(customizeHtml);
    }
    function appendSelectBox()
    {
      counter_field++;
      var select_check_count = counter_field;
       // var d = document.getElementById('textbox-populate');
       var customizeHtml = '';
       customizeHtml += '<div class="fieldbox select_box" id="textbox-selectbox">';
       customizeHtml += '<div class="row">';
       customizeHtml+=    '<div class="col-md-9">';
       customizeHtml+=      '<div><span id="selectspan'+counter_select+'">Selectbox</span></div>';
       customizeHtml+=    '</div>'
       customizeHtml +=   '<div class="col-md-3 align-right">'
       customizeHtml+=      '<div class="btn-element-wrap"><a class="symbol-btn close-btn" href="#" title="Remove Element"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;</a><a class="symbol-btn edit-btn" id="edit-btn-select'+counter_select+'" data-id="'+counter_select+'" href="javascript:void(0);" title="Edit Element"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a></div>';
       customizeHtml+=    '</div>';
       customizeHtml+=  '</div>';
       customizeHtml+= '<div class="row toggle-field" id="toggle-field-select'+counter_select+'">';
       customizeHtml+=    '<div class="">';
       customizeHtml+=      '<div class="container">';
       customizeHtml+=        '<div class="row form-body">';
       customizeHtml+=          '<div class="col-4"><label class="control-label">Label</label><input type="text" name="select_group_label" id="selectlabel'+counter_select+'" data-id="'+counter_select+'" placeholder="Selectbox Group Label" value="Selectbox"></div><div class="col-4"><label class="control-label">Required</label><br><input type="checkbox" name="select_group_required"></div><div class="col-4"><label class="control-label">Order</label><input type="text" name="select_group_order" placeholder="Selectbox Group Order" value="'+counter_field+'"></div>';
       customizeHtml+=        '</div>';
       customizeHtml+=      '</div>';
       customizeHtml+=      '<input type="hidden" name="radio_counter" value="'+select_check_count+'">';
       customizeHtml+=      '<div class="col-12 frm-options form-body"><label class="control-label">Options</label></div>';
       customizeHtml+=      '<div class="container">';
       customizeHtml+=        '<div class="select_wrapper'+counter_select+'">';
       customizeHtml+=          '<div class="row option-row"><div id="check_test" class="col-1 frm-chkbx"></div><div class="col-5"><label class="control-label">Option Label</label></div><div class="col-5"><label class="control-label">Option Value</label></div><div class="col-1 pl-0"></div></div>';
       customizeHtml+=          '<div class="row option-row"><div id="check_test" class="col-1 frm-chkbx"><input type="radio" name="option_check'+select_check_count+'" id="option_check"></div><div class="col-5"><input type="text" placeholder="Option Label" name="option_label[]" value="Option 1"></div><div class="col-5"><input type="text" placeholder="Option Value" name="option_value[]" value="option-1"></div><div class="col-1 pl-0"><button class="select_box_bt select_add_button'+counter_select+'" data-id='+counter_select+'><i class="fa fa-plus"></i></button></div></div>';
       customizeHtml+=        '</div>';
       customizeHtml+=       '</div>';
       customizeHtml+=    '</div>';
       customizeHtml+=  '</div>';

       var select_add_button      = $(".select_add_button"+counter_select); //Add button ID
        var select_wrapper         = $(".select_wrapper"+counter_select); //Fields wrapper

        var selHtml = '';

        $(document).on("keyup","#selectlabel"+counter_select,function(){
           var val = $(this).val();
           var data_id = $(this).data('id');
           //console.log("testing"+data_id);
           $("#selectspan"+data_id).html(val);
        })
       $(document).on("click",".select_add_button"+counter_select,function(e){ //on add input button click
           e.preventDefault();
           var data_id = $(this).data('id');
           console.log(counter_select);
           selHtml+='<div class="row option-row"><div class="col-1 frm-chkbx"><input type="radio" name="option_check'+select_check_count+'" id="option_check"></div><div class="col-5"><input type="text" placeholder="Option Label" name="option_label[]"/></div><div class="col-5"><input type="text" placeholder="Option Value" name="option_value[]"/></div><div class="col-1 pl-0"><a href="#" class="remove_field"><i class="fa fa-minus"></i></a></div></div>';
            $(".select_wrapper"+data_id).append(selHtml); //add input box
            selHtml = '';
       });

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
       //$('#selectbox-populate').append(customizeHtml);
       $('#category-custom-form').append(customizeHtml);
    }
function appendRadioButton()
{
// var d = document.getElementById('textbox-populate');
counter_field++;
var radio_check_count = counter_field;
var customizeHtml = '';
customizeHtml += '<div class="fieldbox radio_group_box" id="textbox-radio">';
customizeHtml += '<div class="row">';
customizeHtml+=    '<div class="col-md-9">';
customizeHtml+=      '<div><span id="radiospan'+counter_radio+'">Radio Button</span></div>';
customizeHtml+=    '</div>'
customizeHtml +=   '<div class="col-md-3 align-right">'
customizeHtml+=      '<div class="btn-element-wrap"><a class="symbol-btn close-btn" href="#" title="Remove Element"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;</a><a class="symbol-btn edit-btn" id="edit-btn-radio'+counter_radio+'" data-id="'+counter_radio+'" href="javascript:void(0);" title="Edit Element"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a></div>';
customizeHtml+=    '</div>';
customizeHtml+=  '</div>';
customizeHtml+= '<div class="row toggle-field" id="toggle-field-radio'+counter_radio+'">';
customizeHtml+=    '<div class="">';
customizeHtml+=      '<div class="container">';
customizeHtml+=        '<div class="row form-body">';
customizeHtml+=         '<div class="col-4"><label class="control-label">Label</label><input type="text" name="radio_group_label" id="radiolabel'+counter_radio+'" data-id="'+counter_radio+'" placeholder="Radio Group Label" value="Radio Button"></div><div class="col-4"><label class="control-label">Required</label><br><input type="checkbox" name="radio_group_required"></div><div class="col-4"><label class="control-label">Order</label><input type="text" name="radio_group_order" placeholder="Radio Group Order" value="'+counter_field+'"></div>';
customizeHtml+=        '</div>';
customizeHtml+=      '</div>';
customizeHtml+=      '<input type="hidden" name="radio_counter" value="'+radio_check_count+'">';
customizeHtml+=      '<div class="col-12 frm-options form-body"><label class="control-label">Options</label></div>';
customizeHtml+=      '<div class="container">';
customizeHtml+=         '<div class="radio_wrapper'+counter_radio+'">';
customizeHtml+=           '<div class="row option-row"><div id="check_test" class="col-1 frm-chkbx"></div><div class="col-5"><label class="control-label">Option Label</label></div><div class="col-5"><label class="control-label">Option Value</label></div><div class="col-1 pl-0"></div></div>';
customizeHtml+=           '<div class="row option-row"><div id="check_test" class="col-1 frm-chkbx"><input type="radio" name="option_check'+radio_check_count+'"></div><div class="col-5"><input type="text" placeholder="Option Label" name="option_label[]" value="Option 1"></div><div class="col-5"><input type="text" placeholder="Option Value" name="option_value[]" value="option-1"></div><div class="col-1 pl-0"><button class="radio_bt radio_add_button'+counter_radio+'" data-id='+counter_radio+'><i class="fa fa-plus"></i></button></div></div>';
customizeHtml+=        '</div>';
customizeHtml+=       '</div>';
customizeHtml+=    '</div>';
customizeHtml+=  '</div>';

var radio_add_button      = $(".radio_add_button"+counter_radio); //Add button ID
var radio_wrapper         = $(".radio_wrapper"+counter_radio); //Fields wrapper
var radHtml = '';

$(document).on("keyup","#radiolabel"+counter_radio,function(){
   var val = $(this).val();
   var data_id = $(this).data('id');
   //console.log("testing"+data_id);
   $("#radiospan"+data_id).html(val);
})
$(document).on("click",".radio_add_button"+counter_radio,function(e){ //on add input button click
   e.preventDefault();
   var data_id = $(this).data('id');
   console.log(counter_radio);
    radHtml+='<div class="row option-row"><div class="col-1 frm-chkbx"><input type="radio" name="option_check'+radio_check_count+'"></div><div class="col-5"><input type="text" placeholder="Option Label" name="option_label[]"/></div><div class="col-5"><input type="text" placeholder="Option Value" name="option_value[]"/></div><div class="col-1 pl-0"><a href="#" class="remove_field"><i class="fa fa-minus"></i></a></div></div>'; 
    $(".radio_wrapper"+data_id).append(radHtml);//add input box
    radHtml = '';
});

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
//$('#radiogroup-populate').append(customizeHtml);
$('#category-custom-form').append(customizeHtml);
}

function appendRateFieldButton()
{
  counter_field++;
// var d = document.getElementById('textbox-populate');
var customizeHtml = '';
customizeHtml += '<div class="fieldbox rate_group_box" id="textbox-rate">';
customizeHtml += '<div class="row">';
customizeHtml+=    '<div class="col-md-9">';
customizeHtml+=      '<div><span id="ratespan'+counter_rate+'">Rate Field</span></div>';
customizeHtml+=    '</div>'
customizeHtml +=   '<div class="col-md-3 align-right">'
customizeHtml+=      '<div class="btn-element-wrap"><a class="symbol-btn close-btn" href="#" title="Remove Element"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbsp;</a><a class="symbol-btn edit-btn" id="edit-btn-rate'+counter_rate+'" data-id="'+counter_rate+'" href="javascript:void(0);" title="Edit Element"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a></div>';
customizeHtml+=    '</div>';
customizeHtml+=  '</div>';
customizeHtml+= '<div class="row toggle-field" id="toggle-field-rate'+counter_rate+'">';
customizeHtml+=    '<div class="">';
customizeHtml+=      '<div class="container">';
customizeHtml+=        '<div class="row form-body">';
customizeHtml+=           '<div class="col-4"><label class="control-label">Label</label><input type="text" name="rate_group_label" id="ratelabel'+counter_rate+'" data-id="'+counter_rate+'" placeholder="Rate Field Label" value="Rate Field"></div><div class="col-4"><label class="control-label">Required</label><br><input type="checkbox" name="rate_group_required"></div><div class="col-4"><label class="control-label">Order</label><input type="text" name="rate_group_order" placeholder="Rate Field Order" value="'+counter_field+'"></div>';
customizeHtml+=        '</div>';
customizeHtml+=      '</div>';
customizeHtml+=      '<div class="col-12 frm-options form-body"><label class="control-label">Options</label></div>';
customizeHtml+=      '<div class="container">';
customizeHtml+=         '<div class="rate_wrapper'+counter_rate+'">';
customizeHtml+=           '<div class="row option-row"><div id="check_test" class="col-11"><input type="text" placeholder="Price Label" name="price_label[]"></div><div class="col-1 pl-0"><button class="rate_bt rate_add_button'+counter_rate+'" data-id='+counter_rate+'><i class="fa fa-plus"></i></button></div></div>';
customizeHtml+=         '</div>';
customizeHtml+=       '</div>';
customizeHtml+=    '</div>';
customizeHtml+=  '</div>';
var rate_add_button      = $(".rate_add_button"+counter_rate); //Add button ID
var rate_wrapper         = $(".rate_wrapper"+counter_rate); //Fields wrapper
var rateHtml = '';
$(document).on("keyup","#ratelabel"+counter_rate,function(){
   var val = $(this).val();
   var data_id = $(this).data('id');
   //console.log("testing"+data_id);
   $("#ratespan"+data_id).html(val);
})
$(document).on("click",".rate_add_button"+counter_rate,function(e){ //on add input button click
   e.preventDefault();
   var data_id = $(this).data('id');
   console.log(counter_rate);
    rateHtml+='<div class="row option-row"><div class="col-11"><input type="text" placeholder="Price Label" name="price_label[]"/></div><div class="col-1 pl-0"><a href="#" class="remove_field"><i class="fa fa-minus"></i></a></div></div>'; //add input box
    $(".rate_wrapper"+data_id).append(rateHtml);
    rateHtml = '';
});

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
//$('#ratefield-populate').append(customizeHtml);
$('#category-custom-form').append(customizeHtml);
}


