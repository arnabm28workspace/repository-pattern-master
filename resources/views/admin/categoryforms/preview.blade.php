
<div class="modal fade" id="myModal{{$form_id}}" role="dialog">
    <div class="modal-dialog modal-dialog-preview">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <div class="hed-prev"><h4 class="modal-title">{{$form_name}}</h4></div>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
            <div class="modal-body-inner-prev">
            <div class="admin-panel__bar">Advert details</div>
             <!--top form section-->
             <div class="container">
              <div class="row">
                  <div class="col-12 col-lg-4 py-2">
                  <label><strong>Country</strong></label>
                  <div class="preview-select">
                      <select disabled name="country_id" id="country_id">
                       <option value="">Select Country</option>
                       <option value="1" cities="Kolkata">India</option>
                      </select>
                  </div>
              </div>
                  <div class="col-12 col-lg-4 py-2">
                  <label><strong>City</strong></label>
                  <div class="preview-select">
                      <select disabled name="country_id" id="country_id">
                       <option value="">Choose City</option>
                       <option value="1" cities="Kolkata">India</option>
                      </select>
                  </div>
              </div>
                  <div class="col-12 col-lg-4 py-2">
                  <label><strong>Category</strong></label>
                  <div class="preview-select">
                      <select disabled name="country_id" id="country_id">
                       <option value="">Category</option>
                       <option value="1" cities="Kolkata">India</option>
                      </select>
                  </div>
              </div>
              </div>
              <div class="row">
                  <div class="col-12 col-lg-6 py-2 form-field">
                  <label><strong>Title</strong></label>
                  <input readonly type="text" name="title" id="title">
                  </div>
                  <div class="col-12 col-lg-2 py-2 form-field">
                  <label><strong>Price</strong></label>
                  <input readonly type="text" name="price" id="title">
                  </div>
                  <div class="col-12 col-lg-4 py-2 form-field">
                      <label for=""><strong>Select Type</strong></label>
                      <div class="preview-select">
                          <select disabled name="country_id" id="country_id">
                           <option value="">Select Type</option>
                           <option value="1" cities="Kolkata">India</option>
                          </select>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-12 col-lg-12 py-2 form-field">
                      <label><strong>Description</strong></label>
                      <div class="text-field-full">
                          <input readonly type="text" name="title" id="title">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-12 col-lg-12 py-2 form-field">
                      <label><strong>Upload photos</strong></label>
                      <div class="upload-photo">
                         <div class="file-up">
                            <span class="faicons" style="background-image:url(http://dev106.developer24x7.com/cnp931/public/frontend/images/file.png);">
                            </span>
                            <h3>Drag files Here
                            <span><i>or</i> click to browse your files</span>
                            </h3>
                         </div>
                      </div>
                  </div>
              </div>
             </div>
            <!--top form section-->
          	<form class="form-group">
          		<div class="container px-3 mt-3 pb-3">		
          			<div class="preview_frm" id="category_field">	
          			</div>
          		</div>
          	</form>
          	</div>
          <div class="bottom-block modal-body-inner-prev mb-4">
             <div class="admin-panel__bar">Personal Details</div>
              <div class="container">
              <div class="row">
                  <div class="col-12 col-lg-4 py-2">
                  <label><strong>Phone</strong></label>
                  <input readonly type="text" name="phone" placeholder="" id="" value="">
                  </div>
                  <div class="col-12 col-lg-4 py-2">
                  <label><strong>Email</strong></label>
                  <input readonly type="text" name="phone" placeholder="" id="" value="">
                  </div>
                  <div class="col-12 col-lg-4 py-2">
                  <label><strong>Website</strong></label>
                  <input readonly type="text" name="phone" placeholder="" id="" value="">
                  </div>
              </div>
              <div class="row pb-3">
                  <div class="col-12 mt-2 terms-cc">
                    <input class="d-inline-block" disabled type="checkbox" checked="checked"> <label style="width:100%;" class="d-inline">I agree to <a href=" ">Terms and Conditions</a></label>
                  </div>
                  <div class="col-12 mt-2 terms-cc">
                    <input class="d-inline-block" disabled type="checkbox" checked="checked"> <label style="width:100%;" class="d-inline">I have read and accept  <a href=" ">Privacy Policy</a></label>
                  </div>
              </div>
              </div>
          </div>
          
        </div>
        <!--modal body end-->
      </div>
    </div>
 </div>

<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		var json_field_values = <?php echo json_encode($field_values)?>;
		var form_id = <?php echo $form_id ?>;
		var field_values = json_field_values;
		var checkbox_type = "checkbox_group";
		var selectbox_type = "selectbox_group";
		var radiobutton_type = "radio_group";
		var ratefield_type = "rate_field_group";
		var textbox_type = "text";
		var textarea_type = "textarea";
		var categoryHTML = '';
		var i, max_order=0;
		for (var key in field_values) {
		    if(field_values[key].order>max_order)
		        max_order = field_values[key].order;
		}
		
		for(i=1; i<=max_order; i++)
		{
		for (var key in field_values) {
		    if(field_values[key].order == i)
		    {
		        if(field_values[key].type == checkbox_type)
		        {
		            categoryHTML = '';
		            categoryHTML+='<div class="col-12 checkbox-container mb-3 pl-0">';
		            categoryHTML+='<label class="label-head mb-2">'+field_values[key].label+'</label>';
		            categoryHTML+='<div class="row">';

		            function slugify(string) {
		            return string
		                .toString()
		                .trim()
		                .toLowerCase()
		                .replace(/\s+/g, "-")
		                .replace(/[^\w\-]+/g, "")
		                .replace(/\-\-+/g, "-")
		                .replace(/^-+/, "")
		                .replace(/-+$/, "");
		            }
		            var field_name = slugify(field_values[key].label);
		            for (var checkbox_value_key in field_values[key].values)
		            {
		                var checkbox_values = field_values[key].values[checkbox_value_key];
                        categoryHTML+='<div class="col-md-3 checkbox-value">';
                        if(checkbox_values.check == 1)
                        {
                          categoryHTML+='<input type="checkbox" disabled value="'+checkbox_values.value+'" name="'+field_name+'[]'+'" checked>';
                        }else{
                          categoryHTML+='<input type="checkbox" disabled value="'+checkbox_values.value+'" name="'+field_name+'[]'+'">';
                        }
		                categoryHTML+='<label class="check-container">'+checkbox_values.label;
		                categoryHTML+='</label>';
                        categoryHTML+='</div>';
		            }
		            categoryHTML+='</div>';
		            categoryHTML+='</div>';
		            $("#myModal"+form_id+" #category_field").append(categoryHTML);
		        }
		        else if(field_values[key].type == selectbox_type)
                {
                    categoryHTML = '';
                    categoryHTML+='<div class="col-12 pl-0 mb-3">';
                    categoryHTML+='<div class="row">';
                    categoryHTML+='<div class="col-md-12">';
                    categoryHTML+='<label class="label-head">'+field_values[key].label+'</label>';
                    categoryHTML+='</div>';
                    categoryHTML+='<div class="col-md-5">';
                    categoryHTML+='<div class="preview-select">';
                    categoryHTML+='<select name="'+field_values[key].label+'" disabled>';
                    for (var selectbox_value_key in field_values[key].values)
                    {
                        var selectbox_values = field_values[key].values[selectbox_value_key];
                        if(selectbox_values.check == 1)
                        {
                          categoryHTML+='<option value="'+selectbox_values.value+'" selected>';
                        }else{
                          categoryHTML+='<option value="'+selectbox_values.value+'">';
                        }
                        categoryHTML+= selectbox_values.label+'</option>';
                    }
                    categoryHTML+='</select>';
                    categoryHTML+='</div>';
                    categoryHTML+='</div>';
                    categoryHTML+='</div>';
                    categoryHTML+='</div>';
                    $("#myModal"+form_id+" #category_field").append(categoryHTML);
                }
		        else if(field_values[key].type == radiobutton_type)
		        {
		            categoryHTML = '';
		            categoryHTML+='<div class="col-12 pl-0">';
		            categoryHTML+='<label class="label-head">'+field_values[key].label+'</label>';
		            function slugify(string) {
		            return string
		                .toString()
		                .trim()
		                .toLowerCase()
		                .replace(/\s+/g, "-")
		                .replace(/[^\w\-]+/g, "")
		                .replace(/\-\-+/g, "-")
		                .replace(/^-+/, "")
		                .replace(/-+$/, "");
		            }
		            var field_name = slugify(field_values[key].label);
		            for (var radiobutton_value_key in field_values[key].values)
		            {
		                var radiobutton_values = field_values[key].values[radiobutton_value_key];
		                categoryHTML+='<div class="row">';
                    if(radiobutton_values.check == 1)
                    {
                      categoryHTML+=  '<div class="col-md-1 align-left">';
                      categoryHTML+=    '<input type="radio" disabled value="'+radiobutton_values.value+'" name="'+field_name+'" checked>';
                      categoryHTML+=  '</div>';
                      categoryHTML+=  '<div class="col-md-5 radio-fld">';
                      categoryHTML+=    '<label>'+radiobutton_values.label+'</label>';
                      categoryHTML+=  '</div>';
                    }else{
                      categoryHTML+=  '<div class="col-md-1 align-left">';
                      categoryHTML+=    '<input type="radio" disabled value="'+radiobutton_values.value+'" name="'+field_name+'">';
                      categoryHTML+=  '</div>';
                      categoryHTML+=  '<div class="col-md-5 radio-fld">';
                      categoryHTML+=    '<label>'+radiobutton_values.label+'</label>';
                      categoryHTML+=  '</div>';
                    }
		                categoryHTML+='</div>';
		            }
		            
		            categoryHTML+='</div>';
		            $("#myModal"+form_id+" #category_field").append(categoryHTML);
		        }
		        else if(field_values[key].type == ratefield_type)
		        {
		        categoryHTML = '';
		        categoryHTML+='<div class="col-12 pl-0 mb-4">';
		        categoryHTML+='<label class="rates-label" for="">'+field_values[key].label+'</label>';
		        categoryHTML+='<div class="rates">';
		        categoryHTML+='<div class="row"><div class="col-2"></div><div class="col-5">Incall</div><div class="col-5">Outcall</div></div>';
		        for (var ratefield_value_key in field_values[key].values)
		        {
		            var ratefield_values = field_values[key].values[ratefield_value_key];
		            categoryHTML+='<div class="row">';
		            categoryHTML+='<div class="col-2"><label for="">'+ratefield_values.label+'</label></div><div class="col-5"><input type="text" readonly name="incall[]"></div><div class="col-5"><input type="text" readonly name="outcall[]"> <input type="hidden" name="time[]" value="'+ratefield_values.label+'"></div>';
		            categoryHTML+='</div>';
		        }
		        categoryHTML+='</div>';
		        categoryHTML+='</div>';
		        $("#myModal"+form_id+" #category_field").append(categoryHTML); 
		        }
		        else if(field_values[key].type == textarea_type)
                {
                    categoryHTML = '';
                    categoryHTML+='<div class="col-12 pl-0">';
                    categoryHTML+='<div class="row">';
                    categoryHTML+='<div class="col-md-12">';
                    categoryHTML+='<label class="label-head">'+field_values[key].label+'</label>';
                    categoryHTML+='</div>';
                    categoryHTML+='<div class="col-md-12 textarea-field">';
                    categoryHTML+='<textarea name="'+field_values[key].name+'" class="detail_ad" readonly/>';
                    categoryHTML+='</div>';
                    categoryHTML+='</div>';
                    categoryHTML+='</div>';
                    $("#myModal"+form_id+" #category_field").append(categoryHTML);
                }
                else if(field_values[key].type == textbox_type)
                {
                    categoryHTML = '';
                    categoryHTML+='<div class="col-12 pl-0 mb-4">';
                    categoryHTML+='<div class="row">';
                    categoryHTML+='<div class="col-md-12">';
                    categoryHTML+='<label class="label-head">'+field_values[key].label+'</label>';
                    categoryHTML+='</div>';
                    categoryHTML+='<div class="col-md-5">';
                    categoryHTML+='<input type="text" readonly name="'+field_values[key].name+'">';
                    categoryHTML+='</div>';
                    categoryHTML+='</div>';
                    categoryHTML+='</div>';
                    $("#myModal"+form_id+" #category_field").append(categoryHTML);
                }  

		    }
		    //console.log(field_values[key]);
		}  
		}
	</script>
